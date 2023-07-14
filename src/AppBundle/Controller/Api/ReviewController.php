<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\AbstractClientController;
use AppBundle\Entity\Review;
use AppBundle\Entity\Message;
use AppBundle\Entity\Order;
use AppBundle\Entity\User;
use AppBundle\Form\CallbackType;
use AppBundle\Type\MessageEventType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/*
 * Форма отзыва
 */
class ReviewController extends AbstractClientController
{
    /**
     * @Route("/review/", name="review")
     *
     * @param Request $request
     *
     * @return Response|JsonResponse
     */
    public function addAction(Request $request)
    {
        $this->article = 'request_form';
        $orderRepo = $this->getDoctrine()->getRepository(Order::class);

        $order = $orderRepo->findOneBy($params = [
            'id' => $request->get('id', 0),
            'user' => $this->getUser()
        ]);

        if (!$order) {
            throw $this->createNotFoundException(
                'No order was found for this id: ' . $params['id']
            );
        }

        $review = new Review();
        $form = $this->createFormBuilder($review, [
                'action' => $this->generateUrl('review', ['id' => $params['id']]),
                'method' => 'POST',
            ])
            ->add('name', TextType::class)
            ->add('comment', TextareaType::class, ['mapped' => false])
            ->getForm()
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $review->getText()->setRaw(nl2br($form->get('comment')->getData()));
            $review->getText()->setFormatted(nl2br($form->get('comment')->getData()));
            $review->getText()->setType('richhtml');
            $review->setOrder($order);
            $review->setStatus(0);
            $review->setCreatedAt(new \DateTime('now'));

            $em->persist($review);
            $em->flush();

            $msgParams = [
                'to' => $order->getExecutor(),
                'from' => $this->getUser(),
                'order' => $order,
                'eventType' => MessageEventType::_ADD_REVIEW];
            $this->getDoctrine()->getRepository(Message::class)
                ->addMessage($msgParams);

            $this->container->get('app.swiftmailer_notify_helper')->sendMail(8, ['review' => $review]);

            $templateParams['done'] = 1;

        } else {

            $templateParams['item'] = $order;
            $templateParams['form'] = $form->createView();
        }

        $formTemplate = 'form/includes/form-review.html.twig';
        $answer = $this->render($formTemplate, $templateParams)->getContent();

        return new JsonResponse($answer);
    }
}
