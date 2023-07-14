<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Catalogue;
use AppBundle\Entity\Page;
use AppBundle\Entity\BannerPlace;
use AppBundle\Entity\CmfScript;
use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Главная страница
 */
class IndexController extends AbstractClientController
{
    /**
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction()
    {
        $this->setArticle('mainClientPage'); // TODO: Вынести артикулы в отдельный файл AppBundle/Type в константы

        $scriptRepo = $this->getDoctrine()->getRepository(CmfScript::class);

        $params = ['script' => $scriptRepo->findOneByArticle($this->article)];

        $designerRepo = $this->getDoctrine()->getRepository(User::class);
        $params['designers'] = $designerRepo->getDesignersForMain();

        $catalogueRepo = $this->getDoctrine()->getRepository(Catalogue::class);
        $params['indexCatalogues'] = $catalogueRepo->findBy(array(
            'onMain' => 1,
            'depth' => 2,
            'status' => 1
        ));

        $pageRepo = $this->getDoctrine()->getRepository(Page::class);
        $bannerPlaceRepo = $this->getDoctrine()->getRepository(BannerPlace::class);
        $bannerPlaces = [7, 8, 9, 10, 11, 12];
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
        $articleRepo = $this->getDoctrine()->getRepository(Article::class);
        $params['articles'] = $articleRepo->getItems()
                ->setMaxResults(3)
                ->getQuery()
                ->getResult();

        $params['top_articles'] = $articleRepo->getItems()
                ->andWhere('c.onMain = 1')
                ->andWhere('c.user = 2')
                ->setMaxResults(2)
                ->getQuery()
                ->getResult();

        return $this->render('index/index.html.twig', $params);
    }
}
