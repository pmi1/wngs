<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\AbstractClientController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Поисковый контроллер
 */
class SearchController extends AbstractClientController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function titleAction(Request $request)
    {
        $q = $request->query->get('term');
        
        $elasticHelper = $this->get('app.elastic_helper');
        $results = $elasticHelper->titlesSearch($q);
        
        return new JsonResponse($results);
    }
}
