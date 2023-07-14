<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

/**
 * Класс для управления структурой клиентской части сайта.
 */
class ScriptAdmin extends CmfScriptAdmin
{
    /**
     * Корень дерева.
     */
    public $rootNodeId = 2;

    /**
     * @var string $baseRouteName Задаем собственный префикс для маршрутов данного админ-скрипта
     */
    protected $baseRouteName = 'script';

    /**
     * @var string $baseRouteName Задаем маску урла, по которой будут подхватываться маршруты
     */
    protected $baseRoutePattern = '/script';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        /*
        $formMapper->remove('roles');
        */
        $formMapper
            ->tab('Item Selections')
                ->with('Item Selections')
                    ->add('cmfScriptSelections', 'sonata_type_collection', array('by_reference' => false, 'required' => false), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                    ))
                ->end()
            ->end();
    }
}
