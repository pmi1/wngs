<?php

namespace Application\Sonata\MediaBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\MediaBundle\Admin\ORM\MediaAdmin as Admin;

class MediaAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'string', array('template' => '@SonataMedia/MediaAdmin/list_image_custom.html.twig'))
            ->add('description')
            ->add('enabled')
            ->add('size')
        ;
    }
}
