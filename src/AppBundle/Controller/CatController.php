<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Catalogue;
use AppBundle\Entity\Item;
use AppBundle\Entity\Review;
use AppBundle\Entity\Selection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Контроллер пользовательской части для рубрики
 */
class CatController extends AbstractClientController
{
        /**
     * Matches /cat/*
     *
     * @Route("/cat/{slug}", name="cat_show", requirements={"slug"=".+[^\/]$"})
     *
     * @param string $slug
     * @param Request $request
     *
     * @return Response
     */
    public function showAction(string $slug, Request $request)
    {
        $this->setArticle('mainClientPage'); // TODO: Вынести артикулы в отдельный файл AppBundle/Type в константы

        $catalogueRepo = $this->getDoctrine()->getRepository(Catalogue::class);
        $catalogue = $catalogueRepo->findOneBy(array(
            'realcatname' => $slug,
            'status' => 1
        ));

        if (!$catalogue) {
            throw $this->createNotFoundException(
                'No catalogue was found for this slug: ' . $slug
            );
        }

        $catalogueParents = $catalogueRepo->getParents($catalogue->getId());

        foreach ($catalogueParents as $key => $value) {
            $this->addBreadCrumb($this->generateUrl('cat_show', array('slug' => $value->getRealcatname())), $value->getName());
        }

        $menu = $catalogueRepo->getTree($catalogueParents[0]->getId(), 1, 1, ['t.realcatname', 't.previewFormatted', 'identity(t.image) as image']);

        $is[] = $catalogue->getId();


        $catalogues = $catalogueRepo->getDatagridTree($catalogue->getId())
            ->andWhere('t.status=1')
            ->getQuery();

        foreach ($catalogues->getResult() as $key => $value) {
            $is[] = $value->getId();
        }
        if ($catalogue->getParentId() === 0) {
            return $this->render('catalogue/top-section.html.twig', array(
                'catalogue' => $catalogue,
                'catalogues' => $menu,
            ));
        } else {

            $result = $this->getDoctrine()->getRepository(Item::class)->_getResults($request, ['catalogue' => $is]);

            return $this->render('catalogue/show.html.twig', array_merge($result, [
                'catalogue' => $catalogue,
                'catalogues' => $menu,
                'catalogueParents' => $catalogueParents
            ]));
        }
    }

    /**
     * Matches /collection/*
     *
     * @Route("/collection/{slug}", name="collection_show", requirements={"slug"=".+[^\/]$"})
     *
     * @param string $slug
     * @param Request $request
     *
     * @return Response
     */
    public function collectionAction(string $slug, Request $request)
    {
        $this->setArticle('mainClientPage');

        $catalogueRepo = $this->getDoctrine()->getRepository(Catalogue::class);
        $selectionRepo = $this->getDoctrine()->getRepository(Selection::class);
        $selection = $selectionRepo->findOneBy(array(
            'link' => $slug,
            'status' => 1
        ));

        if (!($selection
            && (!$selection->getUser() || ($selection->getUser()
            && $selection->getUser()->getDesigner()
            && $selection->getUser()->getActiveCatalogue())))) {
            throw $this->createNotFoundException(
                'No selection was found for this slug: ' . $slug
            );
        }

        $this->addBreadCrumb($this->generateUrl('collection_show', array('slug' => $slug)), $selection->getName());

        $result = $this->getDoctrine()->getRepository(Item::class)->_getResults($request, ['selection' => $selection->getId(), 'cats' => $request->get('cats', false)]);

        $result['catalogue'] = $selection;

        return $this->render('catalogue/show.html.twig', $result);
    }



    /**
     * Matches /sale/
     *
     * @Route("/sale/", name="sale")
     * @param Request $request
     *
     * @return Response
     */
    public function saleAction(Request $request)
    {
        $this->setArticle('saleIndex');

        $options = ['selection' => [$this->container->getParameter('sale_id')
                            , $this->container->getParameter('flash_sale_id')
                            , $this->container->getParameter('sale_predictor_id')]
                            , 'cats' => $request->get('cats', false)];

        if ($options['cats']) {

            $options['catalogue'] = [];
            $catalogueRepo = $this->getDoctrine()->getRepository(Catalogue::class);

            foreach ($options['cats'] as $key => $value) {
                $options['catalogue'] = array_merge($options['catalogue'], $catalogueRepo->getParents($value));
            }
        }

        $result = $this->getDoctrine()->getRepository(Item::class)->_getResults($request, $options);
        $result['filter']['value']['q'] = '';

        return $this->render('search/index.html.twig', $result);
    }

    /**
     * Matches /item/*
     *
     * @Route("/item/{slug}", name="item_show")
     *
     * @param string $slug
     * @param Request $request
     *
     * @return Response
     */
    public function itemAction(string $slug, Request $request)
    {
        $this->setArticle('mainClientPage');

        $itemRepo = $this->getDoctrine()->getRepository(Item::class);

        $item = $itemRepo->findOneBy(array(
            'link' => $slug,
            'status' => 1
        ));

        if (!($item
            && $item->getUser()->getDesigner()
            && $item->getUser()->getActiveCatalogue())) {
            throw $this->createNotFoundException(
                'No item was found for this slug: ' . $slug
            );
        }

        $itemStr = $request->cookies->get('shownItems');

        $cookie = [$item->getId()];
        
        if ($itemStr !== null) {
            $items = explode(';', $itemStr);

            foreach ($items as $i) {
                if (preg_match('/^(\d+)$/', $i, $matches)) {
                    if((int) $matches[1] && !in_array((int) $matches[1], $cookie)){
                        $cookie[] = (int) $matches[1];
                    }
                }

                if (count($cookie) === 10) {
                    break;
                }
            }
        }
        
        $response = new Response();
        $response->headers->setCookie(new Cookie('shownItems', implode(';', $cookie), time() + 604800, '/', null, false, false));
        $response->sendHeaders();


        $selectionRepo = $this->getDoctrine()->getRepository(Selection::class);
        $selection = $selectionRepo->getItems(array(
                'itemSelections' => $item->getId(),
                'user' => $item->getUser()
            ))->setMaxResults(1)->getQuery()->getOneOrNullResult();

        $catalogueRepo = $this->getDoctrine()->getRepository(Catalogue::class);
        $catalogueParents = $catalogueRepo->getParents($item->getCatalogue());

        foreach ($catalogueParents as $key => $value) {
            $this->addBreadCrumb($this->generateUrl('cat_show', array('slug' => $value->getRealcatname())), $value->getName());
        }

        $this->addBreadCrumb($this->generateUrl('item_show', array('slug' => $slug)), $item->getName());

        $menu = $catalogueRepo->getTree(isset($catalogueParents[0]) ? $catalogueParents[0]->getId() : 0, 1, 1, ['t.realcatname']);

        $reviews = $this->getDoctrine()->getRepository(Review::class)->getItems([
            'item' => $item->getId(),
            'status' => 1
        ])->getQuery()->getResult();

        return $this->render('catalogue/item.html.twig', [
            'item' => $item,
            'selection' => $selection,
            'catalogues' => $menu,
            'catalogueParents' => $catalogueParents,
            'reviews' => $reviews,
        ]);
    }

    /**
     * Matches /search/
     *
     * @Route("/search/", name="search")
     * @param Request $request
     *
     * @return Response
     */
    public function searchAction(Request $request)
    {
        $this->setArticle('searchIndex');

        $options = ['q' => $request->get('q', false)
                            , 'cats' => $request->get('cats', false)];

        if ($options['cats']) {

            $options['catalogue'] = [];
            $catalogueRepo = $this->getDoctrine()->getRepository(Catalogue::class);

            foreach ($options['cats'] as $key => $value) {
                $options['catalogue'] = array_merge($options['catalogue'], $catalogueRepo->getParents($value));
            }
        }

        $result = $this->getDoctrine()->getRepository(Item::class)->_getResults($request, $options);
        $result['filter']['value']['q'] = $options['q'];

        return $this->render('search/index.html.twig', $result);
    }


}
