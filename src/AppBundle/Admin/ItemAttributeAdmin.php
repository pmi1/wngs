<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Form\Type\AjaxCascadeSelectType;
use Symfony\Component\Form\CallbackTransformer;

/**
 * Class ItemAttributeAdmin
 */
class ItemAttributeAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('form/fields.html.twig')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('attribute', 'sonata_type_model', array())
            ->add('value', 'text')
        ;
    }
}
