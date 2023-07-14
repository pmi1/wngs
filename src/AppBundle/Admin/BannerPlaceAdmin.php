<?php

namespace AppBundle\Admin;

use AppBundle\Entity\BannerPlace;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Validator\Constraints\Range;

class BannerPlaceAdmin extends ListCommonAdmin
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
            ->end()
            ->tab('Pages')
                ->with('Pages')
                    ->add('pages', 'sonata_type_collection', array('by_reference' => false, 'required' => false), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                    ))
                ->end()
            ->end();
    }
}
