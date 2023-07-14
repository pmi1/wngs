<?php

namespace AppBundle\Admin;

use AppBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Админка управления пользователями
 */
class UserAdmin extends AbstractAdmin
{
    /**
     * @var string $clientPageRoute Название маршрута для карточки на клиентской части.
     */
    protected $clientPageRoute = 'designer_show';
    protected $datagridValues = [
        '_sort_by' => 'createdAt',
        '_sort_order' => 'DESC',
    ];
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('tab.explore')
                ->with('tab.content')
                    ->add('name', 'text', array('label' => 'user.name'))
                    ->add('login', 'text', array('label' => 'user.login'))
                    ->add('image', 'sonata_type_model_list', array('required' => false), array(
                        'edit' => 'inline',
                        'inline' => 'standard',
                        'link_parameters' => array(
                            'context' => 'media_context_user_image',
                            'hide_context' => true,
                            'provider' => 'sonata.media.provider.image',
                        )
                    ))
                    ->add('status', 'checkbox', array('required' => false, 'label' => 'status'))
                ->end()
            ->end()
            ->tab('tab.designer')
                ->with('tab.designer')
                    ->add('designer', 'checkbox', array('required' => false, 'label' => 'designer'))
                    ->add('activeCatalogue', 'checkbox', array('required' => false))
                    ->add('userType', 'sonata_type_model', ['empty_data' => NULL])
                    ->add('birthDate', 'sonata_type_date_picker', array(
                        'required' => false,
                        'format' => 'yyyy-MM-dd',
                    ))
                    ->add('onMain', 'checkbox', array('required' => false, 'label' => 'Show on Main Page'))
                    ->add('brand', 'text', array('required' => false, 'label' => 'user.brand'))
                    ->add('brandImage', 'sonata_type_model_list', array('required' => false), array(
                        'edit' => 'inline',
                        'inline' => 'standard',
                        'link_parameters' => array(
                            'context' => 'media_context_brand_image',
                            'hide_context' => true,
                            'provider' => 'sonata.media.provider.image',
                        )
                    ))
                    ->add('country', 'text', array('required' => false))
                    ->add('city', 'text', array('required' => false))
                    ->add('preview.type', 'sonata_formatter_type', array(
                        'source_field' => array('textRaw', 'preview.raw'),
                        'source_field_options' => array(
                            'attr' => array('class' => 'span10', 'rows' => 12),
                            'property_path' => 'preview.raw',
                        ),
                        'format_field' => array('textType', 'preview.type'),
                        'format_field_options' => array(
                            'choices' => array('ckeditor' => 'richhtml'),
                            'data' => 'richhtml',
                        ),
                        'target_field' => 'preview.formatted',
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
                    ->add('promo_type', 'sonata_formatter_type', array(
                        'source_field' => 'promo_raw',
                        'source_field_options' => array('attr' => array('class' => 'span10', 'rows' => 12)),
                        'format_field' => 'promo_type',
                        'format_field_options' => array(
                            'choices' => array('ckeditor' => 'richhtml'),
                            'data' => 'richhtml',
                        ),
                        'target_field' => 'promo_formatted',
                        'ckeditor_context' => 'default',
                        'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                        'required' => false,
                    ))
                    ->add('facebook', 'text', array('required' => false))
                    ->add('instagram', 'text', array('required' => false))
                    ->add('twitter', 'text', array('required' => false))
                    ->add('behance', 'text', array('required' => false))
                    ->add('vk', 'text', array('required' => false))
                    ->add('site', 'text', array('required' => false))
                    ->add('delivery_type', 'sonata_formatter_type', array(
                        'source_field' => 'delivery_raw',
                        'source_field_options' => array('attr' => array('class' => 'span10', 'rows' => 12)),
                        'format_field' => 'delivery_type',
                        'format_field_options' => array(
                            'choices' => array('ckeditor' => 'richhtml'),
                            'data' => 'richhtml',
                        ),
                        'target_field' => 'delivery_formatted',
                        'ckeditor_context' => 'default',
                        'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                        'required' => false,
                    ))
                    ->add('payment_type', 'sonata_formatter_type', array(
                        'source_field' => 'payment_raw',
                        'source_field_options' => array('attr' => array('class' => 'span10', 'rows' => 12)),
                        'format_field' => 'payment_type',
                        'format_field_options' => array(
                            'choices' => array('ckeditor' => 'richhtml'),
                            'data' => 'richhtml',
                        ),
                        'target_field' => 'payment_formatted',
                        'ckeditor_context' => 'default',
                        'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                        'required' => false,
                    ))
                    ->add('condition_type', 'sonata_formatter_type', array(
                        'source_field' => 'condition_raw',
                        'source_field_options' => array('attr' => array('class' => 'span10', 'rows' => 12)),
                        'format_field' => 'condition_type',
                        'format_field_options' => array(
                            'choices' => array('ckeditor' => 'richhtml'),
                            'data' => 'richhtml',
                        ),
                        'target_field' => 'condition_formatted',
                        'ckeditor_context' => 'default',
                        'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                        'required' => false,
                    ))
                    ->add('ordering', 'integer', ['required' => false, 'data' => $this->isCurrentRoute('create') ? 500 : $this->getSubject()->getOrdering()])
                ->end()
            ->end()
            ->tab('tab.user_favorite')
                ->with('tab.user_favorite')
                    ->add('favorites', 'sonata_type_collection', array('by_reference' => false, 'required' => false), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                    ))
                ->end()
            ->end()
            ->tab('tab.roles_group')
                ->with('tab.roles_group')
                    ->add('roleGroups', 'sonata_type_model', array('expanded' => true, 'by_reference' => false, 'multiple' => true, 'label' => 'user.roles_group', 'btn_add' => false), array('admin_code' => 'admin.cmfscript'))
                ->end()
            ->end()
            ->tab('user.password')
                ->with('user.password')
                    ->add('plainPassword', 'repeated', array(
                        'required' => false,
                        'type' => 'password',
                        'first_options' => array(
                            'label' => 'user.password',
                            'attr' => array(
                                'autocomplete' => 'off',
                            )
                        ),
                        'second_options' => array('label' => 'user.password_confirmation'),
                        'invalid_message' => 'user.password.mismatch',
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
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id', null, array('label' => 'ID'));
        $datagridMapper->add('name', null, array('label' => 'user.name'));
        $datagridMapper->add('login', null, array('label' => 'user.login'));
        $datagridMapper->add('status', null, array('label' => 'status'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('id', null, array('label' => 'ID'));
        $listMapper->addIdentifier('name', null, array('label' => 'user.name'));
        $listMapper->addIdentifier('login', null, array('label' => 'user.login'));
        $listMapper->add('status', null, array('label' => 'status'));
        $listMapper->add('brand', null, ['label' => 'user.brand'])
                   ->add('url', 'url', [
                                'attributes' => ['target' => '_blank'],
                                'route' => [
                                    'name' => 'designer_show',
                                    'identifier_parameter_name' => 'id',
                                    'identifier_parameter' => 'id'
                                ]
                            ])
                   ->add('preview.formatted', 'html', ['label' => 'Preview Type'])
                   ->add('catalogueItems', 'url', [
                                'label' => 'Item',
                                'attributes' => ['target' => '_blank'],
                                'route' => [
                                    'name' => 'admin_app_item_list',
                                    'identifier_parameter_name' => 'filter[user][value]',
                                    'identifier_parameter' => 'id'
                                ]
                            ])
                   ->add('activeCatalogue', null)
                   ->add('designer', null, ['label' => 'designer'])
                   ->add('userType', 'string');

    }


    public function preValidate($object)
    {
         if ($this->isCurrentRoute('edit')) {
            $user = $this->modelManager
                ->getEntityManager(User::class)
                ->getRepository(User::class)->find($object->getId());

            if (! $object->getPassword()) {
                $object->setPassword($user->getPassword());
            }
        }
    }

    public function createQuery($context = 'list')
    {

        $proxyQuery = parent::createQuery($context);
        $requestQuery = $this->getRequest()->getQueryString();
        if ($requestQuery == NULL || strpos($requestQuery, 'sort_by') === false) {

            $proxyQuery->addOrderBy('o.status', 'ASC');
            $proxyQuery->setSortBy([], ['fieldName' => 'createdAt']);
            $proxyQuery->setSortOrder('DESC');
        }

        return $proxyQuery;
    }
}
