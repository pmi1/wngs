<?php

namespace AppBundle\Admin;

use AppBundle\Doctrine\SecurityGeneratorListener;
use AppBundle\Entity\CmfScript;
use AppBundle\Form\Type\MultipleTreeType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Админка для управления ролями
 */
class RoleAdmin extends AbstractAdmin
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
        $scriptRepo = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository(CmfScript::class);
        $tree = $scriptRepo->getTree(0, 0, 0, array('isGroupNode'));

        $formMapper
            ->tab('Обзор')
                ->with('Контент')
                ->add('name', 'text', array('label' => 'Имя'))
                ->add('status', 'checkbox', array('required' => false, 'label' => 'Вкл'))
                ->end()
            ->end()
            ->tab('Структура')
                ->with('Структура')
                ->add('cmfScripts', MultipleTreeType::class, array('tree' => $tree, 'label' => 'Список для редактирования'), array('admin_code' => 'admin.cmfscript'))
                ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, array('label' => 'Имя'));
        $datagridMapper->add('status', null, array('label' => 'Вкл'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', 'text', array('label' => 'Имя'));
        $listMapper->add('status', 'checkbox', array('label' => 'Вкл'));
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        $this->generateSecurityYML();
    }
    
    /**
     * {@inheritdoc}
     */
    public function postUpdate($object)
    {
        $this->generateSecurityYML();
    }
     
    /**
     * {@inheritdoc}
     */
    public function postRemove($object)
    {
        $this->generateSecurityYML();
    }
    
    /**
     * Обновляем кэш прав
     */
    public function generateSecurityYML()
    {
        $tokenStorage = $this->getConfigurationPool()->getContainer()->get('security.token_storage');
        $entityManager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $SecurityGeneratorListener = new SecurityGeneratorListener($tokenStorage, $entityManager);
        $SecurityGeneratorListener->generateSecurityYML();
    }
}
