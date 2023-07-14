<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Контроллер пользовательской части для стран
 */
class ArticleController extends AbstractClientController
{
    /**
     * Matches /live
     *
     * @Route("/live", name="article_list")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $this->setArticle('articleIndex');

        $articleRepo = $this->getDoctrine()->getRepository(Article::class);
        $query = $articleRepo->getItems();

        $adapter = new DoctrineORMAdapter($query);
        $pager =  new Pagerfanta($adapter);
        $pager->setMaxPerPage($request->get('pagesize', 8));
        
        $page = $request->get('page', 1);

        try  {
            $pager->setCurrentPage($page);
        }
        catch(NotValidCurrentPageException $e) {
          throw new NotFoundHttpException('Illegal page');
        }

        return $this->render('article/index.html.twig', array(
            'articles' => $pager,
        ));
    }

    /**
     * Matches /live/*
     *
     * @Route("/live/{slug}", name="article_show")
     *
     * @param string $slug
     *
     * @return Response
     */
    public function showAction(string $slug)
    {
        $this->setArticle('articleIndex');
        
        $articleRepo = $this->getDoctrine()->getRepository(Article::class);
        $article = $articleRepo->findOneBy(array(
            'link' => $slug,
            'status' => 1
        ));

        if (!$article 
            || !$article->getUser()
            || !$article->getUser()->getStatus()
            || !$article->getUser()->getDesigner()) {
            throw $this->createNotFoundException(
                'No artcile was found for this slug: ' . $slug
            );
        }
        
        $this->addBreadCrumb($this->generateUrl('article_show', array('slug' => $slug)), $article->getName());

        return $this->render('article/show.html.twig', array(
            'article' => $article,
        ));
    }
}
