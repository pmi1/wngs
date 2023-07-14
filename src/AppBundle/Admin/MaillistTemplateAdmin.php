<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\CallbackTransformer;
/**
 * Class MaillistTemplateAdmin
 *
 * Админка почтовых уведомлений
 */
class MaillistTemplateAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Name', 'required' => false))
            ->add('subject')
            ->add('fromName')
            ->add('fromEmail')
            ->add('toName')
            ->add('toEmail')
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
                'ckeditor_context' => 'mail',
                //'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'required' => false,
                'listener' => false,
            ));
    }
}
