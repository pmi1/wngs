<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Форма обратного звонка
 */
class CallbackType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'fio', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('phone', 'text', array('label' => 'Phone', 'attr' => array('class' => 'form-control')));
            //->add('city', 'text', array('label' => 'City', 'required' => false, 'attr' => array('class' => 'form-control')))
            //->add('callTime', 'text', array('label' => 'CallTime', 'required' => false, 'attr' => array('class' => 'form-control')));
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FormAnswer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_form';
    }
}
