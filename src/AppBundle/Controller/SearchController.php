<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Поисковый контроллер
 */
class SearchController extends AbstractClientController
{
    /**
     * Matches /search1/
     *
     * @Route("/search1/", name="search1")
     * @param Request $request
     *
     * @return Response
     */
    /*public function indexAction(Request $request)
    {
        $this->setArticle('searchIndex');

        $elasticHelper = $this->get('app.elastic_helper');

        $results = $elasticHelper->results($request);

        return $this->render('search/index.html.twig', $results);
    }*/

}
