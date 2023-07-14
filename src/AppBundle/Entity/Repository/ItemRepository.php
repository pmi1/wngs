<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Item;
use AppBundle\Entity\Catalogue;
use AppBundle\Entity\ItemCatalogue;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * ItemRepository.
 */
class ItemRepository extends AbstractListRepository
{
    /**
    * Получить список товаров
     *
     * @param array $options список 
     *
     * @return QueryBuilder
     */
    public function getItems($options)
    {
        $em = $this->getEntityManager();
        $select = $em->createQueryBuilder()
            ->select('c')
            ->from(Item::class, 'c')
            ->groupBy('c.id')
            ->addOrderBy(isset($options['sort']) && $options['sort'] && $options['sort'] !== 'price' ?
                     'c.'.$options['sort'] : 'c.price*(100 - COALESCE(c.discount,0))'
                , isset($options['sortDir']) ? $options['sortDir'] : 'ASC')
            ->addOrderBy('c.name', 'ASC');

        if (isset($options['catalogue'])) {
            $select =$select
                ->andWhere($em->getExpressionBuilder()->in('c.id',
                       $em->createQueryBuilder()
                           ->select('IDENTITY(ic.item)')
                           ->from(ItemCatalogue::class, 'ic')
                            ->where('ic.catalogue IN (:catalogueIds)')
                           ->getDQL()
                       )
                   )
                ->orWhere('c.catalogue IN (:catalogueIds)')
                ->setParameter('catalogueIds', $options['catalogue']);
        }

        $select->andWhere('c.status=1');

        if (isset($options['selection']) && $options['selection']) {
            $select =$select
                ->join('c.itemSelections', 'si')
                ->andWhere('si.selection in (:selection) and si.status = 1')
                ->setParameter('selection', $options['selection']);
        }

        if (isset($options['favorite'])) {
            $select =$select
                ->join('c.favorites', 'uf')
                ->andWhere('uf.user IN (:favoriteIds)')
                ->setParameter('favoriteIds', $options['favorite']);
        }

        if (isset($options['q']) && $options['q']) {
            $select =$select
                ->join('c.user', 'd')
                ->andWhere('c.name LIKE :query or d.brand LIKE :query')
                ->setParameter('query', '%'.$options['q'].'%');
        }

        if (isset($options['check']) && $options['check']) {
            $select =$select
                ->join('c.user', 'r')
                ->andWhere('r.designer = 1 and r.activeCatalogue = 1');
        }

        if (isset($options['designers']) && $options['designers']) {
            $select =$select
                ->andWhere('c.user IN (:designerIds)')
                ->setParameter('designerIds', $options['designers']);
        }

        if (isset($options['ids']) && $options['ids']) {
            $select =$select
                ->andWhere('c.id IN (:ids)')
                ->setParameter('ids', $options['ids']);
        }

        if (isset($options['maxPrice']) && $options['maxPrice']) {
            $select =$select
                ->andWhere('(case when c.discount>0 then (c.price*(100 - c.discount) / 100) else c.price end) <= (:maxPrice)')
                ->setParameter('maxPrice', $options['maxPrice']);
        }

        if (isset($options['minPrice']) && $options['minPrice']) {
            $select =$select
                ->andWhere('(case when c.discount>0 then (c.price*(100 - c.discount) / 100) else c.price end) >= (:minPrice)')
                ->setParameter('minPrice', $options['minPrice']);
        }

        return $select;
    }

    /**
    * Получить фильтр список товаров
     *
     * @param array $options список 
     *
     * @return array
     */
    public function getFilter($options)
    {
        $result['value'] = $options;
        unset($options['designers']);
        $result['designers'] = $this->getItems($options)
            ->join('c.user', 'u')
            ->select(array('u.id', 'u.name'))
            ->resetDQLPart('groupBy')
            ->groupBy('u.id')
            ->orderBy('u.name')
            ->getQuery()
            ->getResult();

        $options = $result['value'];
        unset($options['minPrice'], $options['maxPrice']);
        $result['price'] = $this->getItems($options)
            ->resetDQLPart('groupBy')
            ->select(array('min(case when c.discount>0 then (c.price*(100 - c.discount) / 100) else c.price end) as minPrice', 'max(case when c.discount>0 then (c.price*(100 - c.discount) / 100) else c.price end) as maxPrice'))
            ->getQuery()
            ->getOneOrNullResult();

        if (isset($options['cats'])) {
            $options = $result['value'];
            unset($options['catalogue']);
            $result['cats'] = $this->getItems($options)
                ->leftJoin('c.catalogues', 'ic2')
                ->leftJoin(Catalogue::class, 't'
                    , \Doctrine\ORM\Query\Expr\Join::WITH, 't.id = c.catalogue or t.id = ic2.catalogue')
                ->leftJoin(Catalogue::class, 'p'
                    , \Doctrine\ORM\Query\Expr\Join::WITH, 'p.leftMargin <= t.leftMargin and p.rightMargin >= t.rightMargin')
                ->select(array('p.id', 'p.name', 'p.parentId', 'p.depth'))
                ->andWhere('t.realStatus = 1')
                ->andWhere('p.realStatus = 1')
                ->groupBy('p.id')
                ->orderBy('p.depth', Criteria::ASC)
                ->addOrderBy('p.ordering', Criteria::DESC)
                ->getQuery()
                ->getResult();
        }

        if (isset($options['selection'])) {
            $options = $result['value'];
            unset($options['selection']);
            $result['selection'] = $this->getItems($options)
                ->leftJoin('c.itemSelections', 'si')
                ->leftJoin('si.selection', 's')
                ->select(array('s.id', 's.name'))
                ->andWhere('si.id > 0 and si.status = 1')
                ->andWhere('s.status = 1')
                ->groupBy('s.id')
                ->orderBy('s.name', Criteria::ASC)
                ->getQuery()
                ->getResult();
        }
        return $result;
    }

    /**
     *
     * @param Request $request
     * @param array $params
     *
     * @return array
     */
    public function _getResults(Request $request, $params = null)
    {
        $result = [];
        $options = array('minPrice' => $request->get('minPrice', false)
            , 'maxPrice' => $request->get('maxPrice', false)
            , 'designers' => $request->get('designers', false)
            , 'sort' => $request->get('sort', false)
            , 'sortDir' => $request->get('sortDir', false)
            , 'check' => true);

        $options = array_merge($options, $params);
        $result['filter'] = $this->getFilter($options);

        $query = $this->getItems($options)->getQuery();
        
        $adapter = new DoctrineORMAdapter($query, false, false);
        $pager =  new Pagerfanta($adapter);
        $pager->setMaxPerPage($request->get('pagesize', 6));
        
        $page = $request->get('page', 1);

        try  {
            $result['items'] = $pager->setCurrentPage($page);
        }
        catch(NotValidCurrentPageException $e) {
            throw new NotFoundHttpException('Illegal page');
        }

        return $result;
    }
}