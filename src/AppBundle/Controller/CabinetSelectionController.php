<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Selection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormError;
/**
 * Контроллер кабинета по коллекциям
 */
class CabinetSelectionController extends AbstractClientController
{
    /**
     * Matches /cabinet/selection/*
     *
     * @Route("/cabinet/selection/", name="cabinet_selection")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function showAction(Request $request)
    {
        if (! $this->get('security.token_storage')->getToken()->getUser()->getDesigner()) {

            return $this->redirectToRoute('cabinet_profile', ['d' => 1]);
        }

        $this->setArticle('cabinetSelectionPage');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $result['selection'] = $this->getDoctrine()->getRepository(Selection::class)
            ->findBy(['status' => 1, 'user' => $user]);
        $result['sale'] = $this->getDoctrine()->getRepository(Selection::class)
            ->findBy(['status' => 1, 'id' => null, 'id' => [
                            $this->container->getParameter('sale_id')
                            , $this->container->getParameter('flash_sale_id')
                            , $this->container->getParameter('sale_predictor_id')]
                        ]);

        return $this->render('cabinet/selection.html.twig', $result);
    }

    /**
     * Matches /cabinet/selection/delete/*
     *
     * @Route("/cabinet/selection/delete/", name="cabinet_selection_delete")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function itemDeleteAction(Request $request)
    {
        if (! $this->get('security.token_storage')->getToken()->getUser()->getDesigner()) {

            return $this->redirectToRoute('cabinet_profile', ['d' => 1]);
        }

        $this->setArticle('cabinetSelectionPage');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $item = false;
        if ($id = $request->get('id', false)) {
            $item = $this->getDoctrine()->getRepository(Selection::class)->findOneBy(['id' => $id, 'user' => $user]);
        }

        if (!$item) {
            throw $this->createNotFoundException(
                'No item was found for this id: ' . $id
            );
        }

        $result = ['item' => $item];
        if ($id = $request->get('confirm', false)) {
            $item->setStatus(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
            $result['done'] = 1;
        }

        $answer = $this->render('cabinet/selection-delete.html.twig', $result)->getContent();

        return new JsonResponse($answer);

    }

    /**
     * Matches /cabinet/selection/item/*
     *
     * @Route("/cabinet/selection/item/", name="cabinet_selection_item")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function itemAction(Request $request)
    {
        if (! $this->get('security.token_storage')->getToken()->getUser()->getDesigner()) {

            return $this->redirectToRoute('cabinet_profile', ['d' => 1]);
        }

        $this->setArticle('cabinetSelectionPage');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($id = $request->get('id', false)) {
            $item = $this->getDoctrine()->getRepository(Selection::class)->findOneBy(['id' => $id, 'user' => $user]);

            if (!$item) {
                throw $this->createNotFoundException(
                    'No item was found for this id: ' . $id
                );
            }
        } else {
            $item = new Selection();
            $item->setUser($user);
            $item->setStatus(1);
        }

        $form = $this->createFormBuilder($item)
            ->add('name', TextType::class)
            ->add('textRaw', TextareaType::class, ['required' => false])
            ->add('image', 'sonata_media_type', array(
                'required' => true,
                'provider' => 'sonata.media.provider.image',
                'context' => 'media_context_selection_image',
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($item->getImage()){

                $item->setTextFormatted($item->getTextRaw());
                $item->setTextType('richhtml');
                $em = $this->getDoctrine()->getManager();
                $em->persist($item);
                $em->flush();

                return $this->redirectToRoute('cabinet_selection');
            } else {

                $form->get('image')->addError(new FormError($this->get('translator')->trans('This field is required')));
            }
        }

        $params['form'] = $form->createView();

        return $this->render('cabinet/selection-item.html.twig', $params);
    }

}
