<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Дефолтный админ-класс для отображения древовидных сущностей.
 */
class TreeAdmin extends AbstractAdmin
{
    /**
     * Корень дерева.
     */
    public $rootNodeId = 0;

    /**
     * Для select'a дерева не нужно дефолтное ограничение выборки.
     */
    protected $maxPerPage = 0;

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $repo = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass());
        return $repo->getDatagridTree($this->rootNodeId);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('create_child', '{pid}/create');
    }

    /**
     * {@inheritdoc}
     */
    public function configureActionButtons($action, $object = null)
    {
        $list = parent::configureActionButtons($action, $object);

        if ('list' === $action) {
            unset($list['create']);
            $list['create_child'] = array('template' => 'admin/buttons/create_child_button.html.twig');
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getListModes()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'admin/tree.html.twig';
            default:
                return parent::getTemplate($name);
        }
    }
}
