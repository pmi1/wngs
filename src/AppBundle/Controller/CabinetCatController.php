<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use AppBundle\Entity\ItemColor;
use AppBundle\Entity\Attribute;
use AppBundle\Entity\ItemAttribute;
use AppBundle\Entity\Catalogue;
use AppBundle\Entity\Color;
use AppBundle\Entity\Item;
use AppBundle\Entity\ItemCatalogue;
use AppBundle\Entity\ItemSelection;
use AppBundle\Entity\Selection;
use AppBundle\Type\ItemAttributeType;
use AppBundle\Type\ItemGalleryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Application\Sonata\MediaBundle\Entity\Media;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;
use Imagine\Gd\Imagine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

/**
 * Контроллер кабинета по товарам
 */
class CabinetCatController extends AbstractClientController
{
    /**
     * Matches /cabinet/cat/*
     *
     * @Route("/cabinet/cat/", name="cabinet_cat")
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

        $this->setArticle('cabinetCatPage');

        $result = $this->getDoctrine()->getRepository(Item::class)->_getResults($request, [
            'designers' => [$this->get('security.token_storage')->getToken()->getUser()->getId()]
            , 'cats' => $request->get('cats', false)
            , 'selection' => $request->get('selection', false)
            , 'sort' => 'cdate'
            , 'sortDir' => 'DESC'
            //, 'catalogue' => $request->get('cats', false)
            , 'q' => $request->get('q', false)
            , 'check' => false]);

        $pageRepo = $this->getDoctrine()->getRepository(Page::class);
        $result['cat_banners'] = $pageRepo->findBy([
            'bannerPlace' => 14,
            'status' => 1
        ]);

        return $this->render('cabinet/catalogue.html.twig', $result);
    }

    /**
     * Matches /cabinet/cat/delete/*
     *
     * @Route("/cabinet/cat/delete/", name="cabinet_item_delete")
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

        $this->setArticle('cabinetCatPage');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $item = false;
        if ($id = $request->get('id', false)) {
            $item = $this->getDoctrine()->getRepository(Item::class)->findOneBy(['id' => $id, 'user' => $user]);
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

        $answer = $this->render('cabinet/item-delete.html.twig', $result)->getContent();

        return new JsonResponse($answer);

    }

    /**
     * Matches /cabinet/new_selection/
     *
     * @Route("/cabinet/new_selection/", name="cabinet_new_selection")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function newSelectionAction(Request $request)
    {
        if (! $this->get('security.token_storage')->getToken()->getUser()->getDesigner()) {

            return $this->redirectToRoute('cabinet_profile', ['d' => 1]);
        }

        $answer['done'] = false;
        $this->setArticle('cabinetCatPage');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (($name = $request->get('name', false))
                && $item = $this->getDoctrine()->getRepository(Selection::class)
                    ->findOneBy(['name' => $name, 'user' => $user])) {

            $answer['error'] = 'Wrong name!';
        }else {

            $em = $this->getDoctrine()->getManager();
            $selection = new Selection();
            $selection->setUser($user);
            $selection->setStatus(1);
            $selection->setName($name);
            $em->persist($selection);
            $em->flush();
            $answer['done'] = true;
        }

        return new JsonResponse($answer);
    }

    /**
     * Matches /cabinet/item/*
     *
     * @Route("/cabinet/item/", name="cabinet_item")
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

        $this->setArticle('cabinetCatPage');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($id = $request->get('id', false)) {
            $item = $this->getDoctrine()->getRepository(Item::class)->findOneBy(['id' => $id, 'user' => $user]);

            if (!$item) {
                throw $this->createNotFoundException(
                    'No item was found for this id: ' . $id
                );
            }
        } else {
            $item = new Item();
            $item->setStatus(1);
            $item->setDiscount(10);
            $item->setUser($user);
            $item->setCanAskDiscount(true);
            $item->setCdate(new \DateTime('now'));
            $gallery = new Gallery();
            $item->setGallery($gallery);

            $itemSelection = new ItemSelection();
            $itemSelection->setStatus(1);
            $itemSelection->setSelection($this->getDoctrine()
                ->getRepository(Selection::class)
                ->findOneBy(['id' => $this->container->getParameter('sale_id')]));
            $item->addItemSelection($itemSelection);
        }

        $attributes = $this->getDoctrine()
                        ->getRepository(Attribute::class)->findAll();
        $itemAttributes = [];

        foreach ($item->getItemAttributes() as $key => $value) {
            $itemAttributes[] = $value->getAttribute()->getId();
        }

        foreach ($attributes as $value) {

            if (! in_array($value->getId(), $itemAttributes)) {

                $t = new ItemAttribute();
                $t->setItem($item);
                $t->setAttribute($value);
                $item->addItemAttribute($t);
            }
        }

        $selections = $item->getSelections();
        $form = $this->createFormBuilder($item)
            ->add('media', FileType::class, ['mapped' => false, 'required' => false])
            ->add('name', TextType::class)
            ->add('price', IntegerType::class, ['attr' => ['min' =>1]])
            ->add('canAskDiscount', CheckboxType::class, ['required' => false])
            ->add('discount', IntegerType::class, ['required' => false, 'attr' => ['min' =>0, 'max' => 99]])
            ->add('textRaw', TextareaType::class, ['required' => false])
            ->add('delivery', TextareaType::class, ['required' => false])
            ->add('payment', TextareaType::class, ['required' => false])
            ->add('condition', TextareaType::class, ['required' => false])
            ->add('itemAttributes', CollectionType::class, [
                'required' => false,
                'entry_type' => ItemAttributeType::class,
            ])
            ->add('colors', ChoiceType::class, array(
                'multiple' => true,
                'expanded'  => true,
                'mapped' => false,
                'choice_attr' => function($choice, $key, $value) use($item) {
                    $result = ['img' => $choice->getImage()];

                    if ($item->getAllColors()->containsKey($choice->getId())) {
                        $result['checked'] = 'checked';
                    }

                    return $result;
                },
                'choice_label' => function($choice, $key, $value) {
                    return $choice->getName();
                },
                'choices'  => $this->getDoctrine()
                        ->getRepository(Color::class)->findAll(),
            ))
            ->add('catalogues', ChoiceType::class, array(
                'multiple' => true,
                'expanded'  => true,
                'mapped' => false,
                'required' => true,
                'choice_label' => function($category, $key, $value) {
                    return $category->getName();
                },
                'choice_attr' => function($key, $val, $index) use($item) {
                    $result = ['depth' => $key->getDepth(), 'parent' => $key->getParentId(), 'id' => $key->getId()];

                    if ($item->getAllCatalogues()->containsKey($key->getId())) {
                        $result['checked'] = 'checked';
                    }

                    return $result;
                },
                'choices'  => $this->getDoctrine()
                        ->getRepository(Catalogue::class)->findBy(['status' => 1], ['leftMargin' => 'ASC']),
            ))
            ->add('isAvailabile', CheckboxType::class, array(
                'required' => false))
            ->add('promo', CheckboxType::class, array(
                'mapped' => false,
                'required' => false,
                'data' => $selections->containsKey($this->container->getParameter('promo_id')),
            ))
            ->add('sale', ChoiceType::class, array(
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'expanded' => true,
                'choice_label' => function($choice, $key, $value) {
                    return $choice->getName();
                },
                'choice_attr' => function($choice, $val, $index) use($selections) {
                    $result = [];
                    $result['desc'] = $choice->getTextRaw();
                    if ($selections->containsKey($choice->getId())) {
                        $result['checked'] = 'checked';
                    }
 
                    return $result;
                },
                'choices'  => $this->getDoctrine()
                        ->getRepository(Selection::class)
                        ->findBy(['status' => 1, 'user' => null, 'id' => [
                            $this->container->getParameter('sale_id')
                            , $this->container->getParameter('flash_sale_id')
                            , $this->container->getParameter('sale_predictor_id')]]
                        , ['name' => 'ASC'])
                    )
                )
            ->add('selections', ChoiceType::class, array(
                'multiple' => false,
                'mapped' => false,
                'required' => false,
                'expanded' => true,
                'choice_label' => function($choice, $key, $value) {
                    return $choice->getName();
                },
                'choice_attr' => function($choice, $val, $index) use($selections) {
                    $result = ['id' => $choice->getId()];

                    if ($selections->containsKey($choice->getId())) {
                        $result['checked'] = 'checked';
                    }

                    return $result;
                },
                'choices'  => $this->getDoctrine()
                        ->getRepository(Selection::class)
                        ->findBy(['status' => 1, 'user' => $user], ['id' => 'ASC']),
            ))
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use($request) {

                $data = $event->getData();
                $form = $event->getForm();

                $result = false;
                /*$ms = $request->files->get('image', false);

                if ($ms) {

                    foreach ($ms as $key => $value) {

                        if ($value) {

                            $result = true;
                            break;
                        }
                    }
                }

                if (! $result) {

                    $form->get('media')->addError(new FormError($this->get('translator')->trans('This field is required')));

                }


                if (empty($form->get('catalogues')->getData())) {

                  $form->get('catalogues')->addError(new FormError($this->get('translator')->trans('This field is required')));

                }*/

                if (empty($form->get('discount')->getData()) && !empty($form->get('sale')->getData())) {

                  $form->get('discount')->addError(new FormError($this->get('translator')->trans('This field is required')));

                }elseif (empty($form->get('sale')->getData()) && !empty($form->get('discount')->getData())) {

                  //$form->get('sale')->addError(new FormError($this->get('translator')->trans('This field is required')));
                    $data->setDiscount(null);
                }

                $event->setData($data);
            })
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $item->setTextFormatted($item->getTextRaw());
            $item->setTextType('richhtml');

            //картинки

            if (isset($gallery)) {
                $gallery->setName($form->get('name')->getData());
                $gallery->setContext('media_context_item_image');
                $em->persist($gallery);
            }

            $mediaManager = $this->get('sonata.media.manager.media');
            $repo = $this->getDoctrine()->getRepository('ApplicationSonataMediaBundle:Media');
            $repoGhm = $this->getDoctrine()->getRepository('ApplicationSonataMediaBundle:GalleryHasMedia');
            $ms = $request->files->get('media', false);
            $mds = $request->get('delete_media', false);
            $imagine = new \Imagine\Gd\Imagine();
            $size    = new \Imagine\Image\Box(1200, 1200);
            $mode    = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;

            if ($ms) {

                foreach ($ms as $key => $value) {

                    if ($value) {
                        $media = $repo->findOneby(['id' => $key]);
                        $imagine->open($value->getPathname())
                            ->thumbnail($size, $mode)
                            ->save($value->getPathname(), ['format' => $value->getClientOriginalExtension()]);
                        $media->setBinaryContent($value);
                        $mediaManager->save($media);
                    } elseif($mds && isset($mds[$key])) {
                        $media = $mediaManager->findOneBy(['id' => $key]);
                        $ghms = $repoGhm->findBy(['media' => $media]);

                        foreach ($ghms as $key => $ghm) {
                            $em->remove($ghm);
                        }

                        $provider = $this->get($media->getProviderName());
                        $provider->removeThumbnails($media);
                        $mediaManager->delete($media);
                    }
                }
            }

            $ms = $request->files->get('image', false);

            if ($ms) {

                foreach ($ms as $key => $value) {

                    if ($value) {
                        $media = new Media();
                        $media->setContext('media_context_item_image');
                        $media->setProviderName('sonata.media.provider.image');
                        $imagine->open($value->getPathname())
                            ->thumbnail($size, $mode)
                            ->save($value->getPathname(), ['format' => $value->getClientOriginalExtension()]);
                        $media->setBinaryContent($value);
                        $ghm = new GalleryHasMedia();
                        $ghm->setGallery($item->getGallery());
                        $ghm->setMedia($media);
                        $ghm->setPosition($item->getGallery()->getGalleryHasMedias()->count());
                        $item->getGallery()->addGalleryHasMedias($ghm);
                        $mediaManager->save($media);
                        $em->persist($ghm);
                    }
                }
            }

            $em->persist($item);

            //Коллекции + sale + promo
            $selectionInput = array_merge([$form->get('selections')->getData()]
                , $form->get('sale')->getData());

            if ($form->get('promo')->getData()) {
                $selectionInput[] = $this->getDoctrine()
                        ->getRepository(Selection::class)
                        ->findOneById($this->container->getParameter('promo_id'));
            }

            if (count($selectionInput)) {

                foreach ($selectionInput as $key => $value) {

                    if ($value && ! $selections->containsKey($value->getId())) {
                        $itemSelection = new ItemSelection();
                        $itemSelection->setSelection($value);
                        $itemSelection->setStatus(1);
                        $em->persist($itemSelection);
                        $item->addItemSelection($itemSelection);
                    }
                }

                foreach ($item->getItemSelections() as $value) {

                    if (! in_array($value->getSelection(), $selectionInput)) {
                        $item->removeItemSelection($value);
                    }
                }
            }
            //Рубрики
            $catalogues = $form->get('catalogues')->getData();

            foreach ($catalogues as $key => $value) {

                if ($key === 0) {
                    $item->setCatalogue($value);
                } elseif (! $item->getAllCatalogues()->containsKey($value->getId())) {

                    $itemCatalogue = new ItemCatalogue();
                    $itemCatalogue->setCatalogue($value);
                    $em->persist($itemCatalogue);

                    $item->addCatalogue($itemCatalogue);
                }
            }

            $allCatalogues = $item->getAllCatalogues();
            foreach ($allCatalogues as $value) {

                if (! in_array($value, $catalogues)) {
                    $item->removeCatalogue($this->getDoctrine()
                                        ->getRepository(ItemCatalogue::class)->findOneBy(['item' => $item, 'catalogue' => $value]));
                }
            }
            
            //Цвета
            $colors = $form->get('colors')->getData();

            foreach ($colors as $key => $value) {

                if (! $item->getAllColors()->containsKey($value->getId())) {

                    $itemColor = new ItemColor();
                    $itemColor->setColor($value);
                    $em->persist($itemColor);

                    $item->addColor($itemColor);
                }
            }

            $allColors = $item->getAllColors();
            foreach ($allColors as $value) {

                if (! in_array($value, $colors)) {
                    $item->removeColor($this->getDoctrine()
                                        ->getRepository(ItemColor::class)->findOneBy(['item' => $item, 'color' => $value]));
                }
            }

            $em->flush();
            $this->addFlash("success", "Changes saved");

            return $this->redirectToRoute('cabinet_item', array(
                'id'    =>  $item->getId(),
            ));
        }

        $params['form'] = $form->createView();
        $params['cat_banners'] = $this->getDoctrine()->getRepository(Page::class)->findBy([
            'bannerPlace' => 14,
            'status' => 1
        ]);

        return $this->render('cabinet/item.html.twig', $params);
    }
}
