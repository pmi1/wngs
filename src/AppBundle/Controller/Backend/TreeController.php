<?php

namespace AppBundle\Controller\Backend;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Дефолтный админ-контроллер для древовидных сущностей.
 */
class TreeController extends CRUDController
{
    /**
     * Корень дерева.
     */
    protected $rootNode = 0;

    /**
     * Добавляем экшн создания потомка.
     *
     * @return Response
     */
    public function createChildAction()
    {
        return parent::createAction();
    }
}
