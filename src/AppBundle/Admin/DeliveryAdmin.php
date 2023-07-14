<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\CallbackTransformer;
/**
 * Class DeliveryAdmin
 *
 * Админка для доставки
 */
class DeliveryAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('status')
            ->add('ordering');
    }
}
