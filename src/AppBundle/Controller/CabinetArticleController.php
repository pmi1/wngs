<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Application\Sonata\MediaBundle\Entity\Media;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;
use Imagine\Gd\Imagine;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

/**
 * Контроллер кабинета по статьям
 */
class CabinetArticleController extends AbstractClientController
{
    /**
     * Matches /cabinet/article/*
     *
     * @Route("/cabinet/article/", name="cabinet_article")
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

        $this->setArticle('cabinetArticlePage');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $query = $this->getDoctrine()->getRepository(Article::class)
            ->getItems(['designers' => $user]);

        $adapter = new DoctrineORMAdapter($query);
        $pager =  new Pagerfanta($adapter);
        
        $page = $request->get('page', 1);

        try  {
            $pager->setCurrentPage($page);
        }
        catch(NotValidCurrentPageException $e) {
          throw new NotFoundHttpException('Illegal page');
        }

        return $this->render('cabinet/article.html.twig', ['articles' => $pager]);
    }


    /**
     * Matches /cabinet/article/item/*
     *
     * @Route("/cabinet/article/item/", name="cabinet_article_item")
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

        $this->setArticle('cabinetArticlePage');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $item = new Article();
        $item->setUser($user)
            ->setStatus(0)
            ->setOnMain(0)
            ->setCdate(new \DateTime('now'));
        $gallery = new Gallery();
        $item->setGallery($gallery);

        $form = $this->createFormBuilder($item)
            ->add('media', FileType::class, ['mapped' => false, 'required' => false])
            ->add('name', TextType::class)
            ->add('previewRaw', TextareaType::class)
            ->add('textRaw', TextareaType::class)
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use($request) {

                $data = $event->getData();
                $form = $event->getForm();
                $result = false;
                $ms = $request->files->get('image', false);

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

                $event->setData($data);
            })
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $item->setPreviewFormatted(nl2br($item->getPreviewRaw()));
            $item->setPreviewType('richhtml');
            $item->setTextFormatted(nl2br($item->getTextRaw()));
            $item->setTextType('richhtml');

            $em->persist($gallery);

            //картинки
            $gallery->setName($form->get('name')->getData());
            $gallery->setContext('media_context_article_image');
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

                        $em->flush();
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
                        $media->setContext('media_context_article_image');
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
                        $em->flush();
                    }
                }
            }

            $em->persist($item);
            $em->flush();

            $this->container->get('app.swiftmailer_notify_helper')->sendMail(5
                , ['article' => $item]);

            return $this->redirectToRoute('cabinet_article');
        }

        $params['form'] = $form->createView();

        return $this->render('cabinet/article-item.html.twig', $params);
    }

}
