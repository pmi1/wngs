<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\AbstractClientController;
use AppBundle\Type\MessageEventType;
use AppBundle\Entity\Message;
use AppBundle\Entity\UserFavorite;
use AppBundle\Entity\Item;
use AppBundle\Entity\Order;
use AppBundle\Type\FormAnswerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/*
 * Избранное
 */
class FavoriteController extends AbstractClientController
{
    /**
     * @Route("/addtofavorites", name="add_to_favorites")
     *
     * @param Request $request
     *
     * @return Response|JsonResponse
     */
    public function addToFavoritesAction(Request $request)
    {
        $user = $this->getUser();
        $answer = ['count' => 0];
        if ($user) {
            $itemId = $request->get('item');

            if ($itemId) {
                $itemRepo = $this->getDoctrine()->getRepository(Item::class);

                $item = $itemRepo->findOneBy(array(
                    'id' => $itemId,
                    'status' => 1
                ));

                if ($item) {
                    if ($request->get('delete', 0)) {
                        $em = $this->getDoctrine()->getManager();
                        $entity = $em->getRepository(UserFavorite::Class)->findOneBy(['user' => $user, 'item' => $item]);

                        if ($entity != null){
                            $em->remove($entity);
                            $em->flush();
                        }
                        $answer['done'] = 1;
                    } else {
                        $object = new UserFavorite();
                        $object->setUser($user);
                        $object->setItem($item);
                        $validator = $this->get('validator');
                        $errorList = $validator->validate($object);

                        if (count($errorList)) {
                            $answer['error'] = '';
                            foreach ($errorList as $violation) {
                                $answer['error'] = $violation->getMessage().'<br>';
                            }
                        } else {
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($object);
                            $entityManager->flush();

                            $item->setPopularity($item->getPopularity()+1);
                            $entityManager->persist($item);
                            $entityManager->flush();
                            $answer['done'] = 1;
                            //сохраняем заказ
                            $order = new Order();
                            $order->setUser($user);
                            $order->setExecutor($item->getUser());
                            $order->setItem($item);
                            $order->setCdate(new \DateTime('now'));
                            $order->setName($user->getName());
                            $order->setEmail($user->getLogin());
                            $order->setPhone($user->getPhone());
                            $order->setCity($user->getCity());
                            $order->setPrice($item->getPrice());
                            $order->getDiscount($item->getDiscount());
                            $order->setFormType(FormAnswerType::FAVORITE);
                            $order->setStatus(1);
                            $entityManager->persist($order);
                            $entityManager->flush();

                            $msgParams = [
                                'to' => $order->getExecutor(),
                                'from' => $user,
                                'order' => $order,
                                'eventType' => MessageEventType::_ADD_ITEM_TO_FAVORITE];
                            $this->getDoctrine()->getRepository(Message::class)
                                ->addMessage($msgParams);

                            $this->container->get('app.swiftmailer_notify_helper')->sendMail(7
                                , ['order' => $order, 'to' => $item->getUser()->getLogin()]);
                        }
                    }
                } else {
                    $answer['error'] = 'Wrong item!';
                }
            } else {
                $answer['error'] = 'Wrong item!';
            }

            $userFavoriteRepo = $this->getDoctrine()->getRepository(UserFavorite::class);
            $answer['count'] = $userFavoriteRepo->getCount($user->getId());
        } else {
            $answer['noauth'] = 1;
        }


        return new JsonResponse($answer);
    }
}