<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Form\Type\AjaxCascadeSelectType;
use Symfony\Component\Form\CallbackTransformer;

/**
 * Class UserFavoriteAdmin
 */
class UserFavoriteAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('item', 'sonata_type_model', array());
    }
}
