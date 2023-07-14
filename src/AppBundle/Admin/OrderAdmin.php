<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Order;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use AppBundle\Form\Type\TextToLinkType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use AppBundle\Entity\CmfConfigure;
use AppBundle\Type\FormAnswerType;
use AppBundle\Type\OrderStatusType;

/**
 * Class OrderAdmin
 */
class OrderAdmin extends ListCommonAdmin
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
            ->add('formType', 'choice', array(
                'choices' => FormAnswerType::getChoicesSonata(),
                'label' => 'formType',
                'required' => false
            ))
            ->add('status', 'choice', array(
                'choices' => OrderStatusType::getChoicesSonata(),
                'label' => 'Order status',
            ))
            ->add('executor', 'sonata_type_model_list', array('required' => true), array(
                    'admin_code' => 'admin.user',
                ))
            ->add('user', 'sonata_type_model_list', array('required' => true), array(
                    'admin_code' => 'admin.user',
                ))
            ->add('item', 'sonata_type_model_list', array())
            ->add('price')
            ->add('discount')
            ->add('delivery')
            ->add('deliveryType', 'sonata_type_model_list', ['required' => false])
            ->add('name', 'text', array(
                'label' => 'user.name',
                'required' => false
            ))
            ->add('phone', 'text', array('label' => 'Phone', 
                'required' => false
            ))
            ->add('email', 'text', array('required' => false))
            ->add('city', 'text', array( 
                'required' => false
            ))
            ->add('country', 'text', array( 
                'required' => false
            ))
            ->add('zip', 'text', array( 
                'required' => false
            ))
            ->add('street', 'text', array( 
                'required' => false
            ))
            ->add('building', 'text', array( 
                'required' => false
            ))
            ->add('apartment', 'text', array( 
                'required' => false
            ))
            ->add('question', 'textarea', array(
                'label' => 'Your Question',
                'required' => false,
                'attr' => array('rows' => 5),
            ))
            ->add('comment', 'textarea', array(
                'label' => 'Comment',
                'required' => false,
                'attr' => array('rows' => 5),
            ))
            ->add('review', 'entity', [
                'class' => 'AppBundle\Entity\Review',
                'attr' => [
                  'readonly' => true,
                  'disabled'  => true]])
            ->add('cdate', 'sonata_type_date_picker', array(
                'label' => 'Cdate',
                'format' => 'dd-MM-y H:m:ss',
            ));
    }
}
