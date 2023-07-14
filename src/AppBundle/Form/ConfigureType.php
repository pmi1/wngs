<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Форма для задания настройки полей списка
 */
class ConfigureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fields', ChoiceType::class, [
                'choices' => $options['choices'],
                'data' => $options['data'],
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label' => 'Configure Fields',
            ])
            ->add('save', SubmitType::class, array('label' => 'Save'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array('No choices' => 'No choices'),
            'data' => array('No choices'),
        ));
    }
}
