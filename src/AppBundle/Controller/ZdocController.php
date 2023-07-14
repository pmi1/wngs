<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use AppBundle\Entity\BannerPlace;
use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ZdocController
 *
 * Дефолтный обработчик простых текстовых страниц
 */
class ZdocController extends AbstractClientController
{
    /**
     * Matches /selected_prof
     *
     * @Route("/selected_prof", name="selected_prof")
     * @param Request $request
     *
     * @return Response
     */
    public function selectedProfAction(Request $request)
    {
        $scriptManager = $this->get('app.script_manager');
        
        $script = $scriptManager->getScriptByUrl($slug = 'selected_prof');
        
        if (!$script) {
            throw $this->createNotFoundException(
                'No page was found for this slug: ' . $slug
            );
        }
        
        $this->setScriptId($script->getId());

        $params = [
            'script' => $script,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ];

        $pageRepo = $this->getDoctrine()->getRepository(Page::class);
        $bannerPlaceRepo = $this->getDoctrine()->getRepository(BannerPlace::class);
        $bannerPlaces = [19, 20, 21, 22, 23];
;

        foreach ($bannerPlaces as $value) {

            $bannerPlace = $bannerPlaceRepo->findOneBy(array(
                'id' => $value,
                'status' => 1
            ));
            $params['body_banners'][$value] = $bannerPlace ? $pageRepo->findBy([
                'bannerPlace' => $value,
                'status' => 1
            ]) : '';
        }

        $articleRepo = $this->getDoctrine()->getRepository(Article::class);
        $params['articles'] = $articleRepo->getItems()
                ->setMaxResults(2)
                ->getQuery()
                ->getResult();

        return $this->render('doc/selected_prof.html.twig', $params);
    }


    /**
     * @Route("/{slug}", name="docpage", requirements={"slug"=".+[^\/]$"})
     *
     * @param string $slug ЧПУ
     *
     * @return Response
     */
    public function itemAction(string $slug)
    {
        $scriptManager = $this->get('app.script_manager');
        
        $script = $scriptManager->getScriptByUrl($slug);
        
        if (!$script) {
            throw $this->createNotFoundException(
                'No page was found for this slug: ' . $slug
            );
        }
        
        $this->setScriptId($script->getId());

        $params = [
            'script' => $script,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ];

        $banners = ['selected' => [1,2,3,5], 'selected_prof' => [19, 20, 21, 22]];

        if (array_key_exists($slug, $banners)) {

            $pageRepo = $this->getDoctrine()->getRepository(Page::class);
            $bannerPlaceRepo = $this->getDoctrine()->getRepository(BannerPlace::class);
            $bannerPlaces = $banners[$slug];

            foreach ($bannerPlaces as $key => $value) {

                $bannerPlace = $bannerPlaceRepo->findOneBy(array(
                    'id' => $value,
                    'status' => 1
                ));
                $params['body_banners'][$key] = $bannerPlace ? $pageRepo->findBy([
                    'bannerPlace' => $value,
                    'status' => 1
                ]) : '';
            }

            if($slug === 'selected_prof') {

            }
        }

        return $this->render('doc/show.html.twig', $params);
    }

}
