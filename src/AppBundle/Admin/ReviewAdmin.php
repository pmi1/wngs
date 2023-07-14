<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Review;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Validator\Constraints\Range;

class ReviewAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('order', 'sonata_type_model_list')
            ->add('createdAt', 'sonata_type_datetime_picker', array(
                'label' => 'Cdate',
                'format' => 'yyyy-MM-dd HH:mm:ss',
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
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'listener' => false,
            ))

            ->add('status');
    }
}
