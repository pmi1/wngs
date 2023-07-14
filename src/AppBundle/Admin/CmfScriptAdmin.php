<?php

namespace AppBundle\Admin;

use AppBundle\Doctrine\SecurityGeneratorListener;
use AppBundle\Entity\CmfScript;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Класс для управления структурой сайта.
 */
class CmfScriptAdmin extends TreeAdmin
{
    /**
     * @var string $baseRouteName Задаем собственный префикс для маршрутов данного админ-скрипта
     */
    protected $baseRouteName = 'cmfscript';

    /**
     * @var string $baseRouteName Задаем маску урла, по которой будут подхватываться маршруты
     */
    protected $baseRoutePattern = '/cmfscript';

    /**
     * Собираем url страницы на клиентской части.
     *
     * @param CmfScript $object элемент структуры дерева
     *
     * @return string
     */
    public function getClientUrl($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $scriptManager = $container->get('app.script_manager');

        return $scriptManager->generateUrl($object);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $orderingParams = ['label' => 'ordering'];

        $formMapper
            ->tab('Overview')
                ->with('Content');
        
        if ($this->isCurrentRoute('create_child') || $this->isCurrentRoute('create')) {
            $parentId = (int) $this->getRequest()->get('pid');

            $formMapper->add('parent_id', 'hidden', array(
                'label' => 'parent_id',
                'data' => $parentId ? $parentId : 0,
            ));

            $repo = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass());
            $orderingParams['data'] = $repo->getNextOrdering($parentId);
        }

        $formMapper
                    ->add('name', 'text', array(
                        'label' => 'cmfscript_name',
                    ))
                    ->add('url', 'text', array(
                        'label' => 'cmfscript_url',
                        'required' => false,
                        'help' => 'cmf_script_url_help'
                    ))
                    ->add('catname', 'text', array(
                        'label' => 'cmfscript_catname',
                        'required' => false,
                        'help' => 'cmf_script_catname_help'
                    ))
                    ->add('ordering', 'integer', $orderingParams)
                    /*
                      ->add('article', 'text', array(
                      'label' => 'cmfscript_article',
                      'required' => false,
                      ))
                      ->add('modelname', 'text', array(
                      'label' => 'cmfscript_modelname',
                      'required' => false,
                      ))
                     */
                    ->add('preview_type', 'sonata_formatter_type', array(
                        'source_field' => 'preview_raw',
                        'source_field_options' => array('attr' => array('class' => 'span10', 'rows' => 6)),
                        'format_field' => 'preview_type',
                        'format_field_options' => array(
                            'choices' => array('ckeditor' => 'richhtml'),
                            'data' => 'richhtml',
                        ),
                        'target_field' => 'preview_formatted',
                        'ckeditor_context' => 'default',
                        'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                        'required' => false,
                    ))
                    ->add('text_type', 'sonata_formatter_type', array(
                        'source_field' => 'text_raw',
                        'source_field_options' => array('attr' => array('class' => 'span10', 'rows' => 12)),
                        'format_field' => 'text_type',
                        'format_field_options' => array(
                            'choices' => array('ckeditor' => 'richhtml'),
                            'data' => 'richhtml',
                        ),
                        'target_field' => 'text_formatted',
                        'ckeditor_context' => 'default',
                        'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                        'required' => false,
                    ))
                    ->add('status', 'checkbox', array(
                        'label' => 'status',
                        'required' => false,
                    ))
                    ->add('is_group_node', 'checkbox', array(
                        'label' => 'cmfscript_is_group_node',
                        'required' => false,
                        'help' => 'cmf_script_is_group_node_help'
                    ))
                    ->add('is_new_win', 'checkbox', array(
                        'label' => 'cmfscript_is_new_win',
                        'required' => false,
                    ))
                    ->add('is_exclude_path', 'checkbox', array(
                        'label' => 'cmfscript_is_exclude_path',
                        'required' => false,
                        'help' => 'cmf_script_is_exclude_path_help'
                    ))
                    ->add('is_search', 'checkbox', array(
                        'label' => 'cmfscript_is_search',
                        'required' => false,
                        'help' => 'cmf_script_is_search_help'
                    ))
                    ->add('roles', 'sonata_type_model', array(
                        'label' => 'cmfscript_modules',
                        'expanded' => true,
                        'by_reference' => false,
                        'multiple' => true,
                        'required' => false,
                        'btn_add' => false,
                    ))
                ->end()
            ->end()
            ->tab('Meta Tags')
                ->with('Tags')
                    ->add('metaTitle', 'text', array('label' => 'Title', 'required' => false))
                    ->add('metaDescription', 'textarea', array(
                        'label' => 'Description',
                        'required' => false,
                        'attr' => array('rows' => 5),
                    ))
                    ->add('metaKeywords', 'textarea', array(
                        'label' => 'Keywords',
                        'required' => false,
                        'attr' => array('rows' => 5),
                    ))
                ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('name', null, array(
                    'label' => 'cmfscript_name',
                    'sortable' => false,
                ))
                ->add('status', 'boolean', array(
                    'label' => 'status',
                    'sortable' => false,
                ))
                ->add('realcatname', null, array(
                    'label' => 'cmfscript_realcatname',
                    'sortable' => false,
                ))
                ->add('url', null, array(
                    'label' => 'cmfscript_url',
                    'template' => 'admin/list_fields/show_site_tree.html.twig',
                    'sortable' => false,
                ))
                ->add('_action', null, array(
                    'actions' => array(
                        /*
                          'show' => array(
                          'template' => 'admin/buttons/tree__action_show.html.twig'
                          ),
                         */
                        'show_site' => array(
                            'template' => 'admin/buttons/tree__action_show_site.html.twig',
                        ),
                        'create_child' => array(
                            'template' => 'admin/buttons/tree__action_create_child.html.twig',
                        ),
                        'edit' => array(
                            'template' => 'admin/buttons/tree__action_edit.html.twig',
                        ),
                        'delete' => array(
                            'template' => 'admin/buttons/tree__action_delete.html.twig',
                        ),
                    ),
                ));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, array(
                'label' => 'ID',
            ))
            ->add('status', 'boolean', array(
                'label' => 'status',
            ))
            ->add('url', 'text', array(
                'label' => 'cmfscript_url',
            ))
            ->add('catname', 'text', array(
                'label' => 'cmfscript_catname',
            ))
            ->add('preview_formatted', 'html', array(
                'label' => 'cmfscript_preview',
            ))
            ->add('text_formatted', 'html', array(
                'label' => 'cmfscript_text',
            ))
            ->add('ordering', 'integer', array(
                'label' => 'ordering',
            ))
            ->add('is_group_node', 'boolean', array(
                'label' => 'cmfscript_is_group_node',
            ))
            ->add('is_new_win', 'boolean', array(
                'label' => 'cmfscript_is_new_win',
            ))
            ->add('is_exclude_path', 'boolean', array(
                'label' => 'cmfscript_is_exclude_path',
            ))
            ->add('is_search', 'boolean', array(
                'label' => 'cmfscript_is_search',
            ))
            ->add('roles', null, array(
                'label' => 'cmfscript_modules',
            ))
        ;
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
