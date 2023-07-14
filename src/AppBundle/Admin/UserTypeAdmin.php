<?php

namespace AppBundle\Admin;

use AppBundle\Entity\UserType;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Validator\Constraints\Range;

class UserTypeAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Overview')
                ->with('Content')
                ->add('name', 'text')
                ->add('status')
                ->end()
            ->end();
    }
}
