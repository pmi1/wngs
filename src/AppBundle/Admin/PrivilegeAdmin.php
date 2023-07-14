<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class PrivilegeAdmin
 *
 * Класс для управления привилегиями
 */
class PrivilegeAdmin extends AbstractAdmin
{
    /**
     * @var string $parentAssociationMapping Задаем родительский админ-скрипт
     */
    protected $parentAssociationMapping = 'roles_group';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
           ->add('roleGroups', 'sonata_type_model')
           ->add('roles', 'sonata_type_model')
           ->add('isRead', 'checkbox', array('required' => false))
           ->add('isWrite', 'checkbox', array('required' => false))
           ->add('isInsert', 'checkbox', array('required' => false))
           ->add('isDelete', 'checkbox', array('required' => false));
    }
}
