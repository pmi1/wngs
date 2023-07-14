<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\AbstractClientController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Подписка
 */
class SubscribeController extends AbstractClientController
{
    /**
     * @Route("/index/subscribe", name="subscribe")
     *
     * @param Request $request
     * @return Response
     */
    public function subscribeAction(Request $request)
    {
        $email = $request->request->get('email');
        
        $mailchimpHelper = $this->get('app.mailchimp_helper');
        $result = $mailchimpHelper->subscribeEmail($email);

        return $this->render('index/subscribe.html.twig', [
            'result' => $result
        ]);
    }
}
