<?php

namespace AppBundle\Admin;

use AppBundle\Form\Type\PrivilegeType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Админка управления группами ролей
 */
class RoleGroupAdmin extends AbstractAdmin
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
        $roleGroupId = (int) $this->getRequest()->get('id');

        $em = $this->getConfigurationPool()->getContainer()->get('doctrine');
        $connection = $em->getConnection();
        $statement = $connection->prepare('
            SELECT r.name, p.*, r.id as role_id
            FROM  role r
            LEFT JOIN privilege p ON r.id = p.role_id AND p.roles_group_id = :roleGroupId
        '); // SQL и DQL должен храниться в репозитории
        $statement->bindValue('roleGroupId', $roleGroupId);
        $statement->execute();
        $privilegesRows = $statement->fetchAll();
        
        $formMapper
            ->tab('Обзор')
                ->with('Контент')
                    ->add('name', 'text', array('label' => 'Имя'))
                ->end()
            ->end();

        if ($roleGroupId) {
            $formMapper->tab('Привелегии')
                ->with('Привелегии')
                    ->add('privileges', PrivilegeType::class, array('privileges_rows' => $privilegesRows, 'roleGroupId' => $roleGroupId, 'label' => 'Список для редактирования'))
                ->end()
            ->end();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id', null, array('label' => 'Id'));
        $datagridMapper->add('name', null, array('label' => 'Имя'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('roleGroupId', 'text', array('label' => 'Id'));
        $listMapper->addIdentifier('name', 'text', array('label' => 'Имя'));
    }
}
