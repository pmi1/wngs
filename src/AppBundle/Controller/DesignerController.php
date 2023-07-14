<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Article;
use AppBundle\Entity\Review;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
/**
 * Контроллер пользовательской части для дизайнеров
 */
class DesignerController extends AbstractClientController
{
    /**
     * Matches /designers
     *
     * @Route("/designers", name="designer_list")
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $this->setArticle('designerIndex');

        $designerRepo = $this->getDoctrine()->getRepository(User::class);
        $query = $designerRepo->getDesigners();

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
        
        return $this->render('designer/index.html.twig', array(
            'designers' => $pager,
        ));
    }

    /**
     * Matches /designers/*
     *
     * @Route("/designers/{id}", name="designer_show")
     *
     * @param string $id
     *
     * @return Response
     */
    public function showAction(string $id)
    {
        $this->setArticle('designerIndex');
        
        $designerRepo = $this->getDoctrine()->getRepository(User::class);
        $designer = $designerRepo->findOneBy(array(
            'id' => $id,
            'status' => 1,
            'designer' => 1
        ));

        if (!$designer) {
            throw $this->createNotFoundException(
                'No designer was found for this id: ' . $id
            );
        }
        
        $this->addBreadCrumb($this->generateUrl('designer_show', array('id' => $id)), $designer->getBrand());

        $articleRepo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $articleRepo->findBy(array(
            'user' => $designer->getId(),
            'status' => 1
        ), 
        array('cdate' => 'DESC'), 4);

        $reviews = $this->getDoctrine()->getRepository(Review::class)->getItems([
            'designer' => $designer->getId(),
            'status' => 1
        ])->getQuery()->getResult();

        return $this->render('designer/show.html.twig', array(
            'designer' => $designer,
            'articles' => $articles,
            'reviews' => $reviews,
        ));
    }
}
