<?php

namespace AppBundle\Admin;

use AppBundle\Entity\User;
use AppBundle\Entity\Selection;
use AppBundle\Entity\CmfConfigure;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Validator\Constraints\Range;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\Common\Collections\ArrayCollection;

class SelectionAdmin extends ListCommonAdmin
{
    /**
     * @var string $clientPageRoute Название маршрута для карточки на клиентской части.
     */
    protected $clientPageRoute = 'collection_show';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Overview')
                ->with('Content')
                ->add('name', 'text')
                ->add('link')
                ->add('user', 'sonata_type_model_list', array('required' => false))
                ->add('image', 'sonata_type_model_list', array('required' => false), array(
                        'edit' => 'inline',
                        'inline' => 'standard',
                        'link_parameters' => array(
                            'context' => 'media_context_selection_image',
                            'hide_context' => true,
                            'provider' => 'sonata.media.provider.image',
                        )
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
                ->add('status')
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
            if ($v === 'user') {
                $datagridMapper->add('user', 'doctrine_orm_callback', array(
                        'callback' => function ($queryBuilder, $alias, $field, $value) {
                            if (!isset($value['value'])) {
                                return false;
                            } elseif ($value['value']) {
                                $queryBuilder->andWhere($alias.'.user = :id');
                                $queryBuilder->setParameter('id', $value['value']);
                            } else {
                                $queryBuilder->andWhere($alias.'.user IS NULL');
                            }
                            return true;
                        },
                        'field_type' => ChoiceType::class,
                        'field_options' => array(
                            'choices' => array_merge(['- не задан -' => 0], $this->generateChoicesArray($this->modelManager
                                ->getEntityManager(User::class)
                                ->getRepository(User::class)->findAll())),
                        )
                    ));
            } elseif ($v === 'cmfScript') {
                $datagridMapper->add($v, null, array('admin_code' => 'admin.cmfscript'));
            } else {
                $datagridMapper->add($v);
            }
        }
    }

    public function generateChoicesArray($arr) {
        $arrayCollection = $arr instanceof ArrayCollection ? $arr : new ArrayCollection($arr);

        return array_combine(
            $arrayCollection->map(function($item) { return $item->getName(); })->getValues(),
            $arrayCollection->map(function($item) { return (string)$item->getId(); })->getValues()
        );
    }
}
