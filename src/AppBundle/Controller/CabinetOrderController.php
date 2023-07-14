<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use AppBundle\Entity\Delivery;
use AppBundle\Entity\Message;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use AppBundle\Type\OrderStatusType;
use AppBundle\Type\MessageEventType;
use AppBundle\Type\FormAnswerType;
/**
 * Контроллер кабинета по заказам
 */
class CabinetOrderController extends AbstractClientController
{
    /**
     * Matches /cabinet/order/*
     *
     * @Route("/cabinet/order/", name="cabinet_order")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function showAction(Request $request)
    {
        $this->setArticle($request->get('archive', false) ? 'cabinetOrderArchivePage' : 'cabinetOrderPage');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $query = ($orderRepo = $this->getDoctrine()->getRepository(Order::class))
            ->getItems($options = [
                'user' => [$this->get('security.token_storage')->getToken()->getUser()->getId()]
                , 'executor' => $request->get('executor', false)
                , 'item' => $request->get('item', false)
                , 'date' => $request->get('date', false)
                , 'fstatus' => $request->get('fstatus', false)
                , 'archive' => $request->get('archive', false)
                , 'status' => $request->get('status', false)]);

        $result['filter'] = $orderRepo->getFilter($options);

        $adapter = new DoctrineORMAdapter($query);
        $pager =  new Pagerfanta($adapter);

        $page = $request->get('page', 1);

        try  {
            $result['orders'] = $pager->setCurrentPage($page);
        }
        catch(NotValidCurrentPageException $e) {
          throw new NotFoundHttpException('Illegal page');
        }

        return $this->render('cabinet/order.html.twig', $result);
    }

    /**
     * Matches /cabinet/dorder/*
     *
     * @Route("/cabinet/dorder/", name="cabinet_designer_order")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function desinerOrderAction(Request $request)
    {
        if (! $this->get('security.token_storage')->getToken()->getUser()->getDesigner()) {

            return $this->redirectToRoute('cabinet_profile', ['d' => 1]);
        }

        $this->setArticle($request->get('archive', false) ? 'cabinetDesignerOrderArchivePage' : 'cabinetDesignerOrderPage');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $query = ($orderRepo = $this->getDoctrine()->getRepository(Order::class))
            ->getItems($options = [
                'executor' => [$this->get('security.token_storage')->getToken()->getUser()->getId()]
                , 'user' => $request->get('user', false)
                , 'item' => $request->get('item', false)
                , 'date' => $request->get('date', false)
                , 'fstatus' => $request->get('fstatus', false)
                , 'archive' => $request->get('archive', false)
                , 'status' => $request->get('status', false)]);

        $result['filter'] = $orderRepo->getFilter($options);

        $adapter = new DoctrineORMAdapter($query);
        $pager =  new Pagerfanta($adapter);

        $page = $request->get('page', 1);

        try  {
            $result['orders'] = $pager->setCurrentPage($page);
        }
        catch(NotValidCurrentPageException $e) {
          throw new NotFoundHttpException('Illegal page');
        }

        return $this->render('cabinet/designer-order.html.twig', $result);
    }

    /**
     * Matches /cabinet/order/item/*
     *
     * @Route("/cabinet/order/item/", name="cabinet_order_item")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function itemAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $item = false;
        if ($id = $request->get('id', false)) {
            $item = $this->getDoctrine()->getRepository(Order::class)->findOneBy(['id' => $id, 'user' => $user]);
        }

        if (!$item) {
            throw $this->createNotFoundException(
                'No item was found for this id: ' . $id
            );
        }

        $this->setArticle($item->getStatus() === OrderStatusType::_DONE ? 'cabinetOrderArchivePage' : 'cabinetOrderPage');

        $params['order'] = $item;

        $msgParams = [
            'to' => $item->getExecutor(),
            'from' => $user,
            'order' => $item,
            'name' => 'order - '.$id
        ];

        $form = $this->createFormBuilder(new Message)
            ->add('description', TextareaType::class, ['required' => true])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $msgParams['description'] = $_POST['form']['description'];
            $msgParams['eventType'] = MessageEventType::_ADD_NEW_MESSAGE;
            $this->getDoctrine()->getRepository(Message::class)->addMessage($msgParams);
            return $this->redirectToRoute('cabinet_order_item', array(
                'id'    =>  $request->get('id', false),
            ));
        }

        $params['form'] = $form->createView();

        $formOrder = $this->get('form.factory')
            ->createNamedBuilder('formOrder', 'form', $item)
            ->add('deliveryType', ChoiceType::class, [
                'required' => false,
                'expanded'  => true,
                'choices'  => $this->getDoctrine()
                        ->getRepository(Delivery::class)->findBy(['status' => 1], ['ordering' => 'ASC']),
                'choice_label' => 'name'
            ])
            ->add('city', TextType::class, ['required' => false])
            ->add('country', TextType::class, ['required' => false])
            ->add('zip', TextType::class, ['required' => false])
            ->add('street', TextType::class, ['required' => false])
            ->add('building', TextType::class, ['required' => false])
            ->add('apartment', TextType::class, ['required' => false])
            ->add('comment', TextareaType::class, ['required' => false])
            ->getForm();

        $formOrder->handleRequest($request);

        if ($formOrder->isSubmitted() && $formOrder->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $uow = $em->getUnitOfWork();
            $uow->computeChangeSets();
            $changeset = $uow->getEntityChangeSet($item);


            if (! empty($changeset)) {

                $msgParams['eventType'] = MessageEventType::_CHANGE_ORDER_DELIVERY_ADDR;
                $this->getDoctrine()->getRepository(Message::class)->addMessage($msgParams);
            }

            $em->persist($item);
            $em->flush();
            $this->addFlash("success", "Changes saved");

            return $this->redirectToRoute('cabinet_order_item', array(
                'id'    =>  $request->get('id', false),
            ));
        }

        $params['formOrder'] = $formOrder->createView();

        return $this->render('cabinet/order-item.html.twig', $params);
    }

    /**
     * Matches /cabinet/dorder/item/*
     *
     * @Route("/cabinet/dorder/item/", name="cabinet_designer_order_item")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function designerItemAction(Request $request)
    {
        if (! $this->get('security.token_storage')->getToken()->getUser()->getDesigner()) {

            return $this->redirectToRoute('cabinet_profile', ['d' => 1]);
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $item = false;
        if ($id = $request->get('id', false)) {
            $item = $this->getDoctrine()->getRepository(Order::class)->findOneBy(['id' => $id, 'executor' => $user]);
        }

        if (!$item) {
            throw $this->createNotFoundException(
                'No item was found for this id: ' . $id
            );
        }

        $this->setArticle($item->getStatus() === OrderStatusType::_DONE ? 'cabinetDesignerOrderArchivePage' : 'cabinetDesignerOrderPage');

        $params['order'] = $item;

        $msgParams = [
            'to' => $item->getUser(),
            'from' => $user,
            'order' => $item,
            'name' => 'order - '.$id
        ];

        $form = $this->createFormBuilder(new Message)
            ->add('description', TextareaType::class, ['required' => true])
            ->getForm();

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            $msgParams['description'] = $form->get('description')->getData();
            $msgParams['eventType'] = MessageEventType::_ADD_NEW_MESSAGE;
            $this->getDoctrine()->getRepository(Message::class)->addMessage($msgParams);

            if ($item->getStatus() == OrderStatusType::_NEW) {

                $item->setStatus(OrderStatusType::_PROGRESS);
                unset($msgParams['description']);
                $msgParams['eventType'] = MessageEventType::_CHANGE_ORDER_STATUS_PROGRESS;
                $this->getDoctrine()->getRepository(Message::class)->addMessage($msgParams);
                $em->persist($item);
                $em->flush();
            }

            return $this->redirectToRoute('cabinet_designer_order_item', array(
                'id'    =>  $request->get('id', false),
            ));
        }

        $params['form'] = $form->createView();

        $formOrder = $this->get('form.factory')
            ->createNamedBuilder('formOrder', 'form', $item)
            ->add('delivery', TextType::class, ['required' => false])
            ->add('discount', IntegerType::class, ['required' => false])
            ->add('status', ChoiceType::class, array(
                'choices' => OrderStatusType::getChoicesSonata(),
                'expanded' => true,
                'multiple' => false
            ))
            ->getForm();

        $formOrder->handleRequest($request);

        if ($formOrder->isSubmitted() && $formOrder->isValid()) {

            $uow = $em->getUnitOfWork();
            $uow->computeChangeSets();
            $changeset = $uow->getEntityChangeSet($item);

            if (isset($changeset['status']) 
                && array_key_exists(0, $changeset['status'])
                && array_key_exists(1, $changeset['status'])) {

                if ($changeset['status'][0] != OrderStatusType::_DONE
                    && $changeset['status'][1] == OrderStatusType::_DONE) {
                    $this->container->get('app.swiftmailer_notify_helper')->sendMail(6, ['order' => $item, 'to' => $item->getUser()->getLogin()]);
                }

                $statuses = [OrderStatusType::_NEW => MessageEventType::_CHANGE_ORDER_STATUS_NEW
                    , OrderStatusType::_PROGRESS => MessageEventType::_CHANGE_ORDER_STATUS_PROGRESS
                    , OrderStatusType::_CANCEL => MessageEventType::_CHANGE_ORDER_STATUS_CANCEL
                    , OrderStatusType::_DONE => MessageEventType::_CHANGE_ORDER_STATUS_DONE];

                foreach ($statuses as $key => $value) {

                    if ($changeset['status'][0] != $key && $changeset['status'][1] == $key) {
                        $msgParams['eventType'] = $value;
                        $this->getDoctrine()->getRepository(Message::class)->addMessage($msgParams);
                        break;
                    }
                }
            } elseif ($item->getStatus() == OrderStatusType::_NEW) {

                $item->setStatus(OrderStatusType::_PROGRESS);
                $msgParams['eventType'] = MessageEventType::_CHANGE_ORDER_STATUS_PROGRESS;
                $this->getDoctrine()->getRepository(Message::class)->addMessage($msgParams);
            }


            if (isset($changeset['discount']) 
                && array_key_exists(0, $changeset['discount'])
                && array_key_exists(1, $changeset['discount'])) {

                $msgParams['description'] = $this->get('translator')->trans($item->getFormType() == FormAnswerType::DISCOUNT_FORM ? 'designer_confirm_discount' : 'designer_offer_discount').$item->getDiscount(). $this->get('translator')->trans('new_price').$item->getPrice()*(1-$item->getDiscount()/100);
                $msgParams['eventType'] = MessageEventType::_CHANGE_ORDER_DISCOUNT;
                $this->getDoctrine()->getRepository(Message::class)->addMessage($msgParams);
            }

            if (isset($changeset['delivery']) 
                && array_key_exists(0, $changeset['delivery'])
                && array_key_exists(1, $changeset['delivery'])) {

                $msgParams['eventType'] = MessageEventType::_CHANGE_ORDER_DELIVERY;
                $this->getDoctrine()->getRepository(Message::class)->addMessage($msgParams);
            }

            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('cabinet_designer_order_item', array(
                'id'    =>  $request->get('id', false),
            ));

        }

        $params['formOrder'] = $formOrder->createView();

        $params['messages'] = $this->getDoctrine()->getRepository(Message::class)->findBy(['order' => $id], ['cdate' => 'DESC'], 1);

        return $this->render('cabinet/designer-order-item.html.twig', $params);
    }

}
