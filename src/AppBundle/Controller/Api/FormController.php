<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\AbstractClientController;
use AppBundle\Entity\Message;
use AppBundle\Entity\Order;
use AppBundle\Entity\Page;
use AppBundle\Entity\Item;
use AppBundle\Entity\User;
use AppBundle\Entity\RoleGroup;
use AppBundle\Entity\FormAnswer;
use AppBundle\Form\CallbackType;
use AppBundle\Type\MessageEventType;
use AppBundle\Form\RequestType;
use AppBundle\Type\FormAnswerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/*
 * Формы
 */
class FormController extends AbstractClientController
{
    /**
     * @Route("/request/", name="request")
     *
     * @param Request $request
     *
     * @return Response|JsonResponse
     */
    public function requestFormAction(Request $request)
    {
        $this->article = 'request_form';
        $itemRepo = $this->getDoctrine()->getRepository(Item::class);

        $item = $itemRepo->findOneBy($params = [
            'id' => isset($_REQUEST['request']['itemId']) ? $_REQUEST['request']['itemId'] : 0,
            'status' => 1
        ]);

        if (!$item) {
            throw $this->createNotFoundException(
                'No item was found for this id: ' . $params['id']
            );
        }

        $templateParams['item'] = $item;
        $formTemplate = 'form/includes/form-request-layer.html.twig';

        $formAnswer = new FormAnswer();
        $form = $this->createForm(RequestType::class, $formAnswer, array(
            'action' => $this->generateUrl('request'),
            'method' => 'POST',
            'user' => ($user = $this->getUser()),
            'itemId' => isset($_REQUEST['request']['itemId']) ? $_REQUEST['request']['itemId'] : 0,
            'formType' => isset($_REQUEST['request']['formType']) ? $_REQUEST['request']['formType'] : 0,
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userObject = $this->getDoctrine()->getRepository(User::class);

            if ($user) {
                $formAnswer->setName($user->getName());
                $formAnswer->setEmail($user->getLogin());
                $formAnswer->setPhone($user->getPhone());
            } elseif ($user = $userObject->findOneBy(['login' => $form->get('email')->getData()])) {
            } else {
                $user = new User();
                $passwordEncoder = $this->container->get('security.password_encoder');
                $password = $passwordEncoder->encodePassword($user, $plainPassword = substr(md5(rand()), 0, 8));
                $user->setPassword($password);
                $user->setName($form->get('name')->getData());
                $user->setPhone($form->get('phone')->getData());
                $user->setLogin($form->get('email')->getData());
                $user->setStatus(1);
                $roleGroupEntity = $this->getDoctrine()->getRepository(RoleGroup::class);
                $roleGroupArray = $roleGroupEntity->findOneBy(['id' => 4]);
                $user->addRoleGroup($roleGroupArray);

                $em->persist($user);
                $em->flush();

                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->container->get('security.token_storage')->setToken($token);
                $this->container->get('session')->set('_security_main', serialize($token));

                $this->container->get('app.swiftmailer_notify_helper')->sendMail(4, ['user' => $user, 'password' => $plainPassword, 'to' => $user->getLogin()]);
            }

            $formAnswer->setUser($user);
            $object = $this->getDoctrine()->getRepository(Item::class);
            $formAnswer->setItem($object->findOneBy(['id' => $form->get('itemId')->getData()]));
            $formAnswer->setAnsweredAt(new \DateTime('now'));
            $formAnswer->setRefererLink($request->server->get('HTTP_REFERER'));
            $em->persist($formAnswer);
            $em->flush();
            //сохраняем заказ
            $order = new Order();
            $order->setUser($user);
            $order->setExecutor($formAnswer->getItem()->getUser());
            $order->setItem($formAnswer->getItem());
            $order->setCdate(new \DateTime('now'));
            $order->setName($user->getName());
            $order->setEmail($user->getLogin());
            $order->setPhone($user->getPhone());
            $order->setCity($user->getCity());
            $order->setPrice($formAnswer->getItem()->getPrice());
            $order->setDiscount($formAnswer->getItem()->getDiscount());
            $order->setComment($formAnswer->getComment());
            $order->setQuestion($formAnswer->getQuestion());
            $order->setFormType($formAnswer->getFormType());
            $order->setStatus(1);
            $em->persist($order);
            $em->flush();

            $msgParams = [
                'to' => $order->getExecutor(),
                'from' => $user,
                'order' => $order,
                'name' => $order->getComment(),
                'description' => $order->getQuestion(),
                'eventType' => MessageEventType::_ADD_NEW_ORDER];
            $this->getDoctrine()->getRepository(Message::class)
                ->addMessage($msgParams);

            $this->container->get('app.swiftmailer_notify_helper')->sendMail($formAnswer->getFormType()
                , ['order' => $order, 'formAnswer' => $formAnswer, 'to' => $formAnswer->getItem()->getUser()->getLogin()]);

            $pageRepo = $this->getDoctrine()->getRepository(Page::class);

            $template = $pageRepo->findOneBy(array(
                'id' => $formAnswer->getFormType() + 99
            ));

            $answer = $template ? $template->getText()->getRaw() : '<div class="done">thank you</div>';

            return new JsonResponse($answer);
        }

        $templateParams['form'] = $form->createView();
        $answer = $this->render($formTemplate, $templateParams)->getContent();

        return new JsonResponse($answer);
    }
}
