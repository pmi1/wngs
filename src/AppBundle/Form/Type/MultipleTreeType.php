<?php

namespace AppBundle\Form\Type;

use AppBundle\Admin\RoleAdmin;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MultipleTreeType
 *
 * Дерево с возможностью отмечать ветки и сохранять выбор
 */
class MultipleTreeType extends AbstractType implements EventSubscriberInterface
{
    /**
     * @var RoleAdmin
     */
    private $admin;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::SUBMIT => 'onSubmit',
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('tree' => null, 'sonata_field_description' => null, 'allow_extra_fields' => true));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['value'] = array_flip($view->vars['value']->map(function ($entity) {
            return $entity->getId();
        })->toArray());
        $view->vars['tree'] = $options['tree'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->admin = clone $this->getAdmin($options);
        $this->field = $options['sonata_field_description'];
        $builder->addEventSubscriber($this);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'multiple_tree';
    }

    /**
     * {@inheritdoc}
     */
    public function onSubmit(FormEvent $event)
    {
        $scriptRepo = $this->admin->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->field->getAssociationAdmin()->getClass());

        $collection = $event->getForm()->getData();
        $collection->clear();

        if (is_array($this->data)) {
            foreach ($this->data as $id) {
                $collection->add($scriptRepo->find($id));
            }
        }

        $event->setData($collection);
    }

    /**
     * {@inheritdoc}
     */
    public function onPreSubmit(FormEvent $event)
    {
        $this->data = $event->getData();
    }

    /**
     * {@inheritdoc}
     */
    protected function getFieldDescription(array $options)
    {
        if (!isset($options['sonata_field_description'])) {
            throw new \RuntimeException('Please provide a valid `sonata_field_description` option');
        }

        return $options['sonata_field_description'];
    }

    /**
     * @param array $options
     *
     * @return Admin
     */
    protected function getAdmin(array $options)
    {
        return $this->getFieldDescription($options)->getAssociationAdmin();
    }
}
