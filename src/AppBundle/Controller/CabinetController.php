<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\BannerPlace;
use AppBundle\Entity\User;
use AppBundle\Entity\Item;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityRepository;

/**
 * Контроллер кабинета
 */
class CabinetController extends AbstractClientController
{
    /**
     * @Route("/cabinet/", name="cabinet")
     */
    public function indexAction()
    {
        $this->setArticle('cabinetIndex');
        $params = [];
        $pageRepo = $this->getDoctrine()->getRepository(Page::class);
        $bannerPlaceRepo = $this->getDoctrine()->getRepository(BannerPlace::class);
        $bannerPlaces = [15, 16, 17, 18];
        foreach ($bannerPlaces as $key => $value) {
            $bannerPlace = $bannerPlaceRepo->findOneBy(array(
                'id' => $value,
                'status' => 1
            ));
            $params['body_banners'][$value] = $bannerPlace ? $pageRepo->findBy([
                'bannerPlace' => $value,
                'status' => 1
            ]) : '';
        }

        return $this->render('cabinet/index.html.twig', $params);
    }

    /**
     * Matches /cabinet/profile/*
     *
     * @Route("/cabinet/profile/", name="cabinet_profile")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function profileAction(Request $request)
    {
        $this->setArticle('cabinetProfileIndex');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createFormBuilder($user)
            ->add('name')
            ->add('login')
            ->add('birthDate', DateType::class, ['required' => false, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd.MM.yyyy'])
            ->add('phone', TextType::class, ['required' => false])
            ->add('brand', TextType::class, ['required' => false])
            ->add('facebook', TextType::class, ['required' => false])
            ->add('instagram', TextType::class, ['required' => false])
            ->add('twitter', TextType::class, ['required' => false])
            ->add('behance', TextType::class, ['required' => false])
            ->add('vk', TextType::class, ['required' => false])
            ->add('site', TextType::class, ['required' => false])
            ->add('country', TextType::class, ['required' => false])
            ->add('city', TextType::class, ['required' => false])
            ->add('textRaw', TextareaType::class, ['required' => false])
            ->add('deliveryRaw', TextareaType::class, ['required' => false])
            ->add('paymentRaw', TextareaType::class, ['required' => false])
            ->add('conditionRaw', TextareaType::class, ['required' => false])
            ->add('image', 'sonata_media_type', array(
                'provider' => 'sonata.media.provider.image',
                'context' => 'media_context_user_image',
                'required'  => true,
            ))
            ->add('brandImage', 'sonata_media_type', array(
                'provider' => 'sonata.media.provider.image',
                'context' => 'media_context_brand_image'
            ))
            ->add('userType', EntityType::class, [
                'class' => \AppBundle\Entity\UserType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.status = 1');
                },
                'choice_label' => 'name',
                'expanded' => true,
                'disabled' => true,
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use($request) {

                $data = $event->getData();
                $form = $event->getForm();

                if (empty($form->get('image')->getData()) && ($form->get('brand')->getData() || $form->get('brandImage')->getData())) {

                    $form->get('image')->get('binaryContent')->addError(new FormError($this->get('translator')->trans('This field is required')));

                }

                if (empty($form->get('brand')->getData()) && !empty($form->get('brandImage')->getData())) {

                    $form->get('brand')->addError(new FormError($this->get('translator')->trans('This field is required')));

                }

                if (!empty($form->get('brand')->getData()) && empty($form->get('brandImage')->getData())) {

                    $form->get('brandImage')->get('binaryContent')->addError(new FormError($this->get('translator')->trans('This field is required')));

                }

                $event->setData($data);
            })

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setDesigner($user->getBrand() && $user->getImage() && $user->getBrandImage());
            $user->setTextFormatted($user->getTextRaw());
            $user->setTextType('richhtml');
            $user->setDeliveryFormatted($user->getDeliveryRaw());
            $user->setDeliveryType('richhtml');
            $user->setPaymentFormatted($user->getPaymentRaw());
            $user->setPaymentType('richhtml');
            $user->setConditionFormatted($user->getConditionRaw());
            $user->setConditionType('richhtml');
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash("success", "Profile saved");
            return $this->redirectToRoute('cabinet_profile');
        } elseif ($form->isSubmitted() && !$form->isValid()) {

            $this->addFlash("danger", "Required fields");
        }

        $params['form'] = $form->createView();

        return $this->render('cabinet/profile.html.twig', $params);
    }


    /**
     * Matches /cabinet/favorites/*
     *
     * @Route("/cabinet/favorites/", name="cabinet_favorites")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function favoritesAction(Request $request)
    {
        $this->setArticle('favoritePage'); // TODO: Вынести артикулы в отдельный файл AppBundle/Type в константы

        $itemRepo = $this->getDoctrine()->getRepository(Item::class);
        $options = ['favorite' => $this->getUser()->getId(), 'check' => true];

        $query = $itemRepo->getItems($options)->getQuery();
        
        $adapter = new DoctrineORMAdapter($query);
        $pager =  new Pagerfanta($adapter);
        $pager->setMaxPerPage($request->get('pagesize', 6));
        
        $page = $request->get('page', 1);

        try  {
            $pager->setCurrentPage($page);
        }
        catch(NotValidCurrentPageException $e) {
          throw new NotFoundHttpException('Illegal page');
        }

        return $this->render('cabinet/favorites.html.twig', array(
            'items' => $pager,
        ));
    }

    /**
     * Добавляем к параметрам шаблона дефолтные значения: мета-теги, информацию о текущей странице
     *
     * @param array $parameters Параметры, передаваемые в шаблон
     */
    protected function modifyParameters(&$parameters)
    {
        parent::modifyParameters($parameters);
        $itemRepo = $this->getDoctrine()->getRepository(Item::class);
        $request = Request::createFromGlobals();
        $itemStr = $request->cookies->get('shownItems');

        if ($itemStr !== null) {
            $items = explode(';', $itemStr);
            $parameters['shownItems'] = $itemRepo->getItems(['ids' => $items])
                ->setMaxResults(4)
                ->getQuery()
                ->getResult();
        }
    }


}
