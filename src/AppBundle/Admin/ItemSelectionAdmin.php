<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Form\Type\AjaxCascadeSelectType;
use Symfony\Component\Form\CallbackTransformer;


/**
 * Class ItemSelectionAdmin
 */
class ItemSelectionAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->isCurrentRoute('create', 'admin.selection')
            || $this->isCurrentRoute('edit', 'admin.selection')
            || $this->getRequest()->query->get('code') === 'admin.selection') {
            $formMapper->add('item', 'sonata_type_model_list', array());
        } else {
            $formMapper->add('selection', 'sonata_type_model', array());
        }
        $formMapper->add('createdAt', 'sonata_type_datetime_picker')
                ->add('status');

    }
}
