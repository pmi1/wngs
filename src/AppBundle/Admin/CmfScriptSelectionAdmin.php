<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Form\Type\AjaxCascadeSelectType;
use Symfony\Component\Form\CallbackTransformer;

/**
 * Class CmfScriptSelectionAdmin
 */
class CmfScriptSelectionAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->isCurrentRoute('create', 'admin.selection')
            || $this->isCurrentRoute('edit', 'admin.selection')
            || $this->getRequest()->query->get('code') === 'admin.selection') {
            $formMapper->add('cmfScript', 'sonata_type_model', array());
        } else {
            $formMapper->add('selection', 'sonata_type_model', array());
        }
    }
}
