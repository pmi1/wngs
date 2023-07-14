<?php

namespace AppBundle\Admin;

use AppBundle\Doctrine\SecurityGeneratorListener;
use AppBundle\Entity\Catalogue;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Класс для управления структурой сайта.
 */
class CatalogueAdmin extends TreeAdmin
{
    /**
     * @var string $baseRouteName Задаем собственный префикс для маршрутов данного админ-скрипта
     */
    protected $baseRouteName = 'catalogue';

    /**
     * @var string $baseRouteName Задаем маску урла, по которой будут подхватываться маршруты
     */
    protected $baseRoutePattern = '/catalogue';

    /**
     * Собираем url страницы на клиентской части.
     *
     * @param Catalogue $object элемент структуры дерева
     *
     * @return string
     */
    public function getClientUrl($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $catalogueManager = $container->get('app.catalogue');

        return $catalogueManager->generateUrl($object);
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
                        'label' => 'catalogue_name',
                    ))
                    ->add('catname', 'text', array(
                        'label' => 'catalogue_catname',
                        'required' => false,
                        'help' => 'cmf_script_catname_help'
                    ))
                    ->add('ordering', 'integer', $orderingParams)
                    ->add('image', 'sonata_type_model_list', array(), array(
                        'edit' => 'inline',
                        'inline' => 'standard',
                        'link_parameters' => array(
                            'context' => 'media_context_catalogue_image',
                            'hide_context' => true,
                            'provider' => 'sonata.media.provider.image',
                        )
                    ))
                    /*
                      ->add('article', 'text', array(
                      'label' => 'catalogue_article',
                      'required' => false,
                      ))
                      ->add('modelname', 'text', array(
                      'label' => 'catalogue_modelname',
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
                    ->add('textTop.type', 'sonata_formatter_type', array(
                        'source_field' => array('textRaw', 'textTop.raw'),
                        'source_field_options' => array(
                            'attr' => array('class' => 'span10', 'rows' => 12),
                            'property_path' => 'textTop.raw',
                        ),
                        'format_field' => array('textType', 'textTop.type'),
                        'format_field_options' => array(
                            'choices' => array('ckeditor' => 'richhtml'),
                            'data' => 'richhtml',
                        ),
                        'target_field' => 'textTop.formatted',
                        'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                        'required' => false,
                    ))
                    ->add('onMain', 'checkbox', array('required' => false, 'label' => 'Show on Main Page'))
                    ->add('status', 'checkbox', array(
                        'label' => 'status',
                        'required' => false,
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
                    'label' => 'catalogue_name',
                    'sortable' => false,
                ))
                ->add('status', 'boolean', array(
                    'label' => 'status',
                    'sortable' => false,
                ))
                ->add('realcatname', null, array(
                    'label' => 'catalogue_realcatname',
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
            ->add('catname', 'text', array(
                'label' => 'catalogue_catname',
            ))
            ->add('preview_formatted', 'html', array(
                'label' => 'catalogue_preview',
            ))
            ->add('text_formatted', 'html', array(
                'label' => 'catalogue_text',
            ))
            ->add('ordering', 'integer', array(
                'label' => 'ordering',
            ))
        ;
    }
}
