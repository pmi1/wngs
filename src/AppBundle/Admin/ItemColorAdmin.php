<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Form\Type\AjaxCascadeSelectType;
use Symfony\Component\Form\CallbackTransformer;


/**
 * Class ItemColorAdmin
 */
class ItemColorAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->isCurrentRoute('create', 'admin.color')
            || $this->isCurrentRoute('edit', 'admin.color')
            || $this->getRequest()->query->get('code') === 'admin.color') {
            $formMapper->add('item', 'sonata_type_model_list', array());
        } else {
            $formMapper->add('color', 'sonata_type_model', array());
        }
    }
}
