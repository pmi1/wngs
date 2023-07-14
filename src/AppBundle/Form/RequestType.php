<?php

namespace AppBundle\Form;

use AppBundle\Type\FormAnswerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Формы "Купить/Сообщение дизайнеру/Запросить скидку"
 */
class RequestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (! $options['user']) {
            $builder
                ->add('name', TextType::class)
                ->add('email', TextType::class)
                ->add('phone', TextType::class);
        }
        $builder
            ->add('itemId', HiddenType::class, array(
                'data' => isset($options['itemId']) ? $options['itemId'] : '',
                'mapped' => false,
            ))
            ->add('formType', HiddenType::class, ['data' => isset($options['formType']) ? $options['formType'] : ''])
            ->add('question', TextareaType::class, array('required' => true));
        if (!(isset($options['formType']) && in_array($options['formType'], [FormAnswerType::MESSAGE_FORM, FormAnswerType::DISCOUNT_FORM]))) {
            $builder->add('comment', TextareaType::class, array('required' => true));
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FormAnswer',
            'user' => null,
            'formType' => 0,
            'itemId' => 0,
        ));
    }
}
