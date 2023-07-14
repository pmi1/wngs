<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Item;
use AppBundle\Entity\Catalogue;
use AppBundle\Entity\CmfConfigure;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class ItemAdmin extends ListCommonAdmin
{
    /**
     * @var string $clientPageRoute Название маршрута для карточки на клиентской части.
     */
    protected $clientPageRoute = 'item_show';
    protected $customTemlates = [
        'gallery' => 'admin/list_fields/list_image.html.twig',
        'link' => 'admin/list_fields/show_site.html.twig',
    ];
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Overview')
                ->with('Content')
                ->add('name', 'text')
                ->add('link', 'text', array('label' => 'Url', 'required' => false))
                ->add('user', 'sonata_type_model_list', array('required' => true), array(
                        'admin_code' => 'admin.user',
                    ))
                ->add('catalogue', ChoiceType::class, array(
                    'choice_label' => function($category, $key, $value) {
                        return sprintf('%s %s', str_repeat('-', $category->getDepth()-1), $category->getName());
                    },
                    'choices'  => $this->modelManager
                            ->getEntityManager(Catalogue::class)
                            ->getRepository(Catalogue::class)->findBy([], ['leftMargin' => 'ASC']),
                ))
                ->add('cdate', 'sonata_type_date_picker', array(
                    'label' => 'Cdate',
                    'required' => false,
                    'format' => 'dd-MM-y H:m:s',
                ))
                ->add('price', 'number', array('required' => true))
                ->add('discount', 'number', array(
                    'label' => 'Discount for our clients',
                    'required' => false
                ))
                ->add('popularity', 'number', ['required' => false])
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
                ->add('gallery', 'sonata_type_model_list', array(
                    //'btn_list' => false
                ), array(
                        'link_parameters' => array(
                            'context' => 'media_context_item_image',
                            'hide_context' => true,
                        ),
                        'admin_code' => 'sonata.media.admin.gallery',
                    )
                )
                ->add('delivery', 'textarea', array(
                    'required' => false,
                    'attr' => array('rows' => 5),
                ))
                ->add('payment', 'textarea', array(
                    'required' => false,
                    'attr' => array('rows' => 5),
                ))
                ->add('condition', 'textarea', array(
                    'required' => false,
                    'attr' => array('rows' => 5),
                ))
                ->add('isAvailabile')
                ->add('canAskDiscount')
                ->add('status')
                ->end()
            ->end()
            ->tab('Catalogues')
                ->with('Catalogues')
                    ->add('catalogues', 'sonata_type_collection', array('by_reference' => false, 'required' => true), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                    ))
                ->end()
            ->end()
            ->tab('Item Attributes')
                ->with('Item Attributes')
                    ->add('itemAttributes', 'sonata_type_collection', array('by_reference' => false, 'required' => false), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                    ))
                ->end()
            ->end()
            ->tab('Colors')
                ->with('Colors')
                    ->add('colors', 'sonata_type_collection', array('by_reference' => false, 'required' => true), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                    ))
                ->end()
            ->end()
            ->tab('Item Selections')
                ->with('Item Selections')
                    ->add('itemSelections', 'sonata_type_collection', array('by_reference' => false, 'required' => false), array(
                        'edit' => 'inline',
                        'inline' => 'table',
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
        $configure = $this->modelManager
            ->getEntityManager(CmfConfigure::class)
            ->getRepository(CmfConfigure::class);
        $fields = $configure->getFieldsToDisplay($this->getClassnameLabel());
        
        foreach ($fields as $v) {
            if ($v === 'cmfScript') {
                $datagridMapper->add($v, null, array('admin_code' => 'admin.cmfscript'));
            } elseif( $v === 'catalogue') {
                $datagridMapper->add($v, 'doctrine_orm_choice',  array(), ChoiceType::class, array(
                    'choice_label' => function($category, $key, $value) {
                        return sprintf('%s %s', str_repeat('-', $category->getDepth()-1), $category->getName());
                    },
                    'choices'  => $this->modelManager
                            ->getEntityManager(Catalogue::class)
                            ->getRepository(Catalogue::class)->findBy([], ['leftMargin' => 'ASC']),
                ));
            } else {
                $datagridMapper->add($v);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('user.brand', null, ['label' => 'user.brand']);
        $listMapper->add('itemSelections', null, ['label' => 'Sale']);
        parent::configureListFields($listMapper);
    }


    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if ($object->getUser() == false) {
            $custom_error = 'select.user';
            $errorElement->with('user')->addViolation($custom_error)->end();
        }
    }
}
