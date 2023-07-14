<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\CallbackTransformer;
/**
 * Class PageAdmin
 *
 * Админка для статического контента
 */
class PageAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Name', 'required' => false))
            ->add('link', 'text', array('label' => 'Url', 'required' => false))
            ->add('image', 'sonata_type_model_list', array(), array(
                'edit' => 'inline',
                'inline' => 'standard',
                'link_parameters' => array(
                    'context' => 'media_context_page_image',
                    'hide_context' => true,
                    'provider' => 'sonata.media.provider.image',
                )
            ))
            ->add('text.type', 'sonata_formatter_type', array(
                'source_field' => array('textRaw', 'text.raw'),
                'source_field_options' => array(
                    'attr' => array('class' => 'span10', 'rows' => 12),
                    'property_path' => 'text.raw',
                ),
                'format_field' => array('textType', 'text.type'),
                'format_field_options' => array(
                    'choices' => array('ckeditor' => 'richhtml'),
                    'data' => 'richhtml',
                ),
                'target_field' => 'text.formatted',
                //'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'required' => false,
                'listener' => false,
            ))
            ->add('is_new_win', 'checkbox', array(
                'label' => 'cmfscript_is_new_win',
                'required' => false,
            ))
            ->add('status');
    }
}
