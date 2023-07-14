<?php

namespace AppBundle\Form\Type;

use AppBundle\Admin\RoleGroupAdmin;
use AppBundle\Entity\Privilege;
use AppBundle\Entity\Role;
use AppBundle\Entity\RoleGroup;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PrivilegeType
 *
 * Отвечает за работу с типами привелегий: чтение, запись, добавление, удаление
 */
class PrivilegeType extends AbstractType implements EventSubscriberInterface
{
    /**
     * @var RoleGroupAdmin
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
        $resolver->setDefaults(array('privileges_rows' => null, 'roleGroupId' => null, 'sonata_field_description' => null, 'allow_extra_fields' => true));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        //$view->vars['value'] = array_flip($view->vars['value']->map(function($entity) { return $entity->getId(); })->toArray()) ;
        $view->vars['privileges_rows'] = $options['privileges_rows'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->admin = clone $this->getAdmin($options);
        $this->roleGroupId = $options['roleGroupId'];
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
        return 'privilege';
    }

    /**
     * {@inheritdoc}
     */
    public function onSubmit(FormEvent $event)
    {
        $collection = $event->getForm()->getData();
        $collection->clear();

        if (is_array($this->data)) {
            $this->data['is_read'] = (isset($this->data['is_read']) && is_array($this->data['is_read']) ? $this->data['is_read'] : array());
            $this->data['is_write'] = (isset($this->data['is_write']) && is_array($this->data['is_write']) ? $this->data['is_write'] : array());
            $this->data['is_insert'] = (isset($this->data['is_insert']) && is_array($this->data['is_insert']) ? $this->data['is_insert'] : array());
            $this->data['is_delete'] = (isset($this->data['is_delete']) && is_array($this->data['is_delete']) ? $this->data['is_delete'] : array());
            $roleIds = array_unique(array_merge($this->data['is_read'], $this->data['is_write'], $this->data['is_insert'], $this->data['is_delete']));

            foreach ($roleIds as $roleId) {
                $privilege = new Privilege();
                $privilege->setIsRead(in_array($roleId, $this->data['is_read']) ? 1 : 0);
                $privilege->setIsWrite(in_array($roleId, $this->data['is_write']) ? 1 : 0);
                $privilege->setIsInsert(in_array($roleId, $this->data['is_insert']) ? 1 : 0);
                $privilege->setIsDelete(in_array($roleId, $this->data['is_delete']) ? 1 : 0);
                $roleRepo = $this->admin->getConfigurationPool()->getContainer()->get('doctrine')->getRepository(Role::class);
                $privilege->setRoles($roleRepo->find($roleId));
                $roleGroupRepo = $this->admin->getConfigurationPool()->getContainer()->get('doctrine')->getRepository(RoleGroup::class);
                $privilege->setRoleGroups($roleGroupRepo->find($this->roleGroupId));
                $collection->add($privilege);

                $em = $this->admin->getConfigurationPool()->getContainer()->get('doctrine');
                $connection = $em->getConnection();
                $statement = $connection->prepare('
                    DELETE FROM privilege where roles_group_id = :roleGroupId
                ');
                $statement->bindValue('roleGroupId', $this->roleGroupId);
                $statement->execute();
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
