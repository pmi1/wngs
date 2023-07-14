<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Общие ajax-методы для админских разделов
 */
class AdminCommonController extends Controller
{
    /**
     * generationCasesAction - генерация падежей
     *
     * @Route("/generationCases", name="generationCases")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function generationCasesAction(Request $request)
    {
        $query = $request->query->get('name');
        
        $result = $this->get('app.cases_helper')->generateCases($query);
        
        return new JsonResponse($result);
    }
}
