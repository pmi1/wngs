<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Article;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Validator\Constraints\Range;

class ArticleAdmin extends ListCommonAdmin
{
    /**
     * @var string $clientPageRoute Название маршрута для карточки на клиентской части.
     */
    protected $clientPageRoute = 'article_show';
    protected $datagridValues = [
        '_sort_by' => 'cdate',
        '_sort_order' => 'DESC',
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
                ->add('user', 'sonata_type_model_list', array('required' => false), array(
                        'admin_code' => 'admin.user',
                    ))
                ->add('cdate', 'sonata_type_datetime_picker', array(
                    'label' => 'Cdate',
                    'required' => false,
                    'format' => 'yyyy-MM-dd HH:mm:ss',
                ))
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
                ->add('gallery', 'sonata_type_model_list', array(
                    //'btn_list' => false
                ), array(
                        'link_parameters' => array(
                            'context' => 'media_context_article_image',
                            'hide_context' => true,
                        ),
                        'admin_code' => 'sonata.media.admin.gallery',
                    )
                )
                ->add('onMain', 'checkbox', array('required' => false, 'label' => 'Show on Main Page'))
                ->add('status')
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

    public function createQuery($context = 'list')
    {

        $proxyQuery = parent::createQuery($context);
        $requestQuery = $this->getRequest()->getQueryString();
        if ($requestQuery == NULL || strpos($requestQuery, 'sort_by') === false) {

            $proxyQuery->addOrderBy('o.status', 'ASC');
            $proxyQuery->setSortBy([], ['fieldName' => 'cdate']);
            $proxyQuery->setSortOrder('DESC');
        }

        return $proxyQuery;
    }
}
