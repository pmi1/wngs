<?php

namespace AppBundle\Helper;

use Elastica\Query as ElasticaQuery;
use Elastica\Query\BoolQuery;
use Elastica\Query\MatchPhrasePrefix;
use Elastica\Query\MultiMatch;
use Elastica\Query\Match;
use Elastica\Filter\Terms;
use Pagerfanta\Pagerfanta;
use AppBundle\Entity\User;
use AppBundle\Entity\Catalogue;
use Elastica\Aggregation\GlobalAggregation;
use Symfony\Component\HttpFoundation\Request;

/**
 * Класс поиска на базе ElasticSearch
 *
 *
 */
class ElasticHelper extends AbstractHelper
{

    public function results(Request $request, $params = null)
    {
        $options = array('q' => $request->get('q', false)
            , 'minPrice' => $request->get('minPrice', false)
            , 'maxPrice' => $request->get('maxPrice', false)
            , 'designers' => $request->get('designers', false)
            , 'cats' => $request->get('cats', false)
            , 'sort' => $request->get('sort', false)
            , 'sortDir' => $request->get('sortDir', false));

        if ($params && is_array($params)) {
            $options = array_merge($options, $params);
        }

        $boolQuery = $this->buildQuery($options);

        $elasticaQuery = new \Elastica\Query($boolQuery);

        $elasticaQuery->setSort(array(
                ($request->get('sort', 'price') === 'price' ? "priceWithDiscount" : $request->get('sort', 'price')) 
                    => $request->get('sortDir', 'asc'), 'name' => 'asc'));

        $aggrFilter = new \Elastica\Aggregation\Filters('designers');
        $elasticaAggreg= new \Elastica\Aggregation\Terms('designers');
        $elasticaAggreg->setField('user.id');
        $elasticaAggreg->setSize(10);

        $optionsFilter = $options;
        unset($optionsFilter['designers']);
        $aggrFilter->addFilter($this->buildQuery($optionsFilter));
        $aggrFilter->addAggregation($elasticaAggreg);

        $globalAggregation = new GlobalAggregation('global');
        $globalAggregation->addAggregation($aggrFilter);

        $optionsFilter = $options;
        unset($optionsFilter['minPrice']);
        $aggrFilter2 = new \Elastica\Aggregation\Filters('minPrice');
        $aggr = new \Elastica\Aggregation\Min('price');
        $aggr->setField('priceWithDiscount');

        $aggrFilter2->addFilter($this->buildQuery($optionsFilter));
        $aggrFilter2->addAggregation($aggr);

        $globalAggregation->addAggregation($aggrFilter2);

        $optionsFilter = $options;
        unset($optionsFilter['maxPrice']);
        $aggrFilter2 = new \Elastica\Aggregation\Filters('maxPrice');
        $aggr = new \Elastica\Aggregation\Max('price');
        $aggr->setField('priceWithDiscount');

        $aggrFilter2->addFilter($this->buildQuery($optionsFilter));
        $aggrFilter2->addAggregation($aggr);

        $globalAggregation->addAggregation($aggrFilter2);


        $optionsFilter = $options;
        unset($optionsFilter['cats']);
        $aggrFilter2 = new \Elastica\Aggregation\Filters('cats');
        $aggr = new \Elastica\Aggregation\Terms('cats');
        $aggr->setField('allCatalogues.id');
        $aggr->setSize(10);

        $aggrFilter2->addFilter($this->buildQuery($optionsFilter));
        $aggrFilter2->addAggregation($aggr);

        $globalAggregation->addAggregation($aggrFilter2);

        $elasticaQuery->addAggregation($globalAggregation);

        $finder = $this->container->get('fos_elastica.finder.'.$this->container->getParameter('elastic_index_titles').'.item');
        $pager = $finder->findPaginated($elasticaQuery);
        $pager->setMaxPerPage($request->get('pagesize', 12));
        
        $page = $request->get('page', 1);

        try  {
            $pager->setCurrentPage($page);
        }
        catch(NotValidCurrentPageException $e) {
            throw new NotFoundHttpException('Illegal page');
        }

        $is = $pager->getCurrentPageResults();
        $aggregations = $pager->getAdapter()->getAggregations()['global'];

        $filter['value'] = $options;
        $filter['designers'] = [];
        $is = $aggregations['designers']['buckets'][0]['designers']['buckets'];

        if (count($is)) {
            foreach ($is as $v) {
                $ds[] = $v['key'];
            }
            $designerRepo = $this->getRepository(User::class);
            $filter['designers'] = $designerRepo->findBy([
                'designer' => 1,
                'status' => 1,
                'id' => $ds
            ]);
        }

        $filter['cats'] = $ds = [];
        $is = $aggregations['cats']['buckets'][0]['cats']['buckets'];

        if (count($is)) {
            foreach ($is as $v) {
                $ds[] = $v['key'];
            }
            $catRepo = $this->getRepository(Catalogue::class);
            $filter['cats'] = $catRepo->findBy([
                'status' => 1,
                'id' => $ds
            ]);
        }

        $filter['price']['minPrice'] = $aggregations['minPrice']['buckets'][0]['price']['value'];
        $filter['price']['maxPrice'] = $aggregations['maxPrice']['buckets'][0]['price']['value'];

        return [
            'items' => $pager,
            'filter' => $filter,
        ];
    }


    public function buildQuery($options)
    {
        $boolQuery = new BoolQuery();

        if (isset($options['q']) && $options['q']) {
            $fieldQuery = new MultiMatch();
            $fieldQuery->setQuery($options['q']);
            $fieldQuery->setType("phrase_prefix");
            $fieldQuery->setFields(['name', 'user.name']);
            $boolQuery->addMust($fieldQuery);
        }

        if (isset($options['designers']) && $options['designers']) {
            $filter = new \Elastica\Query\Terms();
            $filter->setTerms('user.id', $options['designers']);
            $boolQuery->addFilter($filter);
        }

        if (isset($options['cats']) && $options['cats']) {
            $filter = new \Elastica\Query\Terms();
            $filter->setTerms('allCatalogues.id', $options['cats']);
            $boolQuery->addFilter($filter);
        }

        if (isset($options['minPrice']) && $options['minPrice']) {
            $filter = new \Elastica\Query\Range('priceWithDiscount', ['gte' => $options['minPrice']]);
            $boolQuery->addFilter($filter);
        }

        if (isset($options['sale']) && $options['sale']) {
            $filter = new \Elastica\Query\Terms();
            $filter->setTerms('selections.id', $options['sale']);
            $boolQuery->addFilter($filter);
        }

        if (isset($options['maxPrice']) && $options['maxPrice']) {
            $filter = new \Elastica\Query\Range('priceWithDiscount', ['lte' => $options['maxPrice']]);
            $boolQuery->addFilter($filter);
        }

        return $boolQuery;
    }
}
