<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Message;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use AppBundle\Form\Type\TextToLinkType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use AppBundle\Entity\CmfConfigure;
use AppBundle\Type\MessageEventType;

/**
 * Class MessageAdmin
 */
class MessageAdmin extends ListCommonAdmin
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
            ->add('from', 'sonata_type_model_list', array('required' => true), array(
                    'admin_code' => 'admin.user',
                ))
            ->add('to', 'sonata_type_model_list', array('required' => true), array(
                    'admin_code' => 'admin.user',
                ))
            ->add('order', 'sonata_type_model_list', ['required' => false])
            ->add('name')
            ->add('description')
            ->add('cdate', 'sonata_type_date_picker', array(
                'label' => 'Cdate',
                'format' => 'dd-MM-y H:m:ss',
            ))
            ->add('eventType', 'choice', array(
                'choices' => MessageEventType::getChoicesSonata(),
            ))
            ->add('isNew');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('id', null, array(
                    'label' => 'admin_message_id',
                    'sortable' => true,
                ))
                ->add('name', null, array(
                    'label' => 'admin_message_name',
                    'sortable' => true,
                ))
                ->add('cdate', 'datetime', array(
                    'label' => 'admin_message_date',
                    'sortable' => true,
                ))
                ->add('event_type', 'integer', array(
                    'label' => 'admin_message_event_type',
                    'sortable' => true,
                ))
                ->add('is_new', 'boolean', array(
                    'label' => 'admin_message_is_new_status',
                    'sortable' => true,
                ))
                ->add('_action', null, array(
                    'actions' => array(
                        'edit' => array(
                            'template' => 'admin/buttons/tree__action_edit.html.twig',
                        ),
                        'delete' => array(
                            'template' => 'admin/buttons/tree__action_delete.html.twig',
                        ),
                    ),
                ));
    }
}
