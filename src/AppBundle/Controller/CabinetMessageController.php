<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Контроллер пользовательской части для сообщений
 */
class CabinetMessageController extends AbstractClientController
{
    /**
     * Matches /cabinet/message/list/
     *
     * @Route("/cabinet/message/list/", name="cabinet_message_list")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $this->setArticle('cabinetMessagePage');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $query = $this->getDoctrine()->getRepository(Message::class)
            ->getItems(['to' => $user->getid()]);

        $adapter = new DoctrineORMAdapter($query);
        $pager =  new Pagerfanta($adapter);
        
        $page = $request->get('page', 1);

        try  {
            $pager->setCurrentPage($page);
        }
        catch(NotValidCurrentPageException $e) {
          throw new NotFoundHttpException('Illegal page');
        }

        $em = $this->getDoctrine()->getManager();

        foreach ($pager->getCurrentPageResults() as $value) {

            $value->setIsNew(0);
            $em->persist($value);
            $em->flush();
        }

        return $this->render('cabinet/message.html.twig', array(
            'messages' => $pager,
        ));
    }

    /**
     * Matches /cabinet/message/list/new/
     *
     * @Route("/cabinet/message/list/new/", name="cabinet_new_message_list")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listNewAction(Request $request)
    {
        $this->setArticle('cabinetMessagePage');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $query = $this->getDoctrine()->getRepository(Message::class)
            ->getItems(['to' => $user->getid(), 'isNew' => 1]);

        $adapter = new DoctrineORMAdapter($query);
        $pager =  new Pagerfanta($adapter);
        
        $page = $request->get('page', 1);

        try  {
            $pager->setCurrentPage($page);
        }
        catch(NotValidCurrentPageException $e) {
          throw new NotFoundHttpException('Illegal page');
        }

        $em = $this->getDoctrine()->getManager();

        foreach ($pager->getCurrentPageResults() as $value) {

            $value->setIsNew(0);
            $em->persist($value);
            $em->flush();
        }

        return $this->render('cabinet/message.html.twig', array(
            'messages' => $pager,
        ));
    }

    /**
     * Matches /cabinet/message/item/*
     *
     * @Route("/cabinet/message/item/{slug}", name="cabinet_message_show")
     *
     * @param int $slug
     *
     * @return Response
     */
    public function showAction(int $slug)
    {
        $this->setArticle('cabinetMessagePage');
        
        $messageRepo = $this->getDoctrine()->getRepository(Message::class);
        $message = $messageRepo->findOneBy(array(
            'id' => $slug
        ));

        if (!$message) {
            throw $this->createNotFoundException(
                'No message was found for this slug: ' . $slug
            );
        }

        return $this->render('cabinet/message-item.html.twig', array(
            'message' => $message,
        ));
    }
}
