<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\CallbackTransformer;
/**
 * Class ColorAdmin
 *
 * Админка для цветов
 */
class ColorAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('image', 'sonata_type_model_list', array(), array(
                'edit' => 'inline',
                'inline' => 'standard',
                'link_parameters' => array(
                    'context' => 'media_context_color_image',
                    'hide_context' => true,
                    'provider' => 'sonata.media.provider.image',
                )
            ));
    }
}
