<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\FormAnswer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use AppBundle\Form\Type\TextToLinkType;
use AppBundle\Form\Type\ClinicToLinkType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use AppBundle\Entity\CmfConfigure;
use AppBundle\Type\FormAnswerType;

/**
 * Class FormAnswerAdmin
 */
class FormAnswerAdmin extends ListCommonAdmin
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
        $formMapper
            ->add('formType', 'choice', array(
                'choices' => FormAnswerType::getChoicesSonata(),
                'label' => 'formType',
                'required' => false
            ))
            ->add('user', 'sonata_type_model_list', array('required' => true), array(
                    'admin_code' => 'admin.user',
                ))
            ->add('item', 'sonata_type_model_list', array())
            ->add('name', 'text', array(
                'label' => 'user.name',
                'required' => false
            ))
            ->add('phone', 'text', array('label' => 'Phone', 
                'required' => false
            ))
            ->add('email', 'text', array('required' => false))
            ->add('question', 'textarea', array(
                'label' => 'Your Question',
                'required' => false,
                'attr' => array('rows' => 5),
            ))
            ->add('comment', 'textarea', array(
                'label' => 'Comment',
                'required' => false,
                'attr' => array('rows' => 5),
            ))
            ->add('answeredAt', 'sonata_type_date_picker', array(
                'label' => 'Answer Date',
                'format' => 'dd-MM-y H:m:ss',
            ))
            ->add('refererLink', TextToLinkType::class, array(
                'label' => 'Referer Link',
                'admin' => $this,
                'mapped' => true
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
            ->add('formType', 'choice', array(
                'choices' => FormAnswerType::getChoices(),
                'label' => 'formType',
                'catalogue' => null
            ))
            ->add('user', 'sonata_type_model_list', array(
                    'admin_code' => 'admin.user',
                ))
            ->add('item', 'sonata_type_model_list', array())
            ->add('name', 'text', array(
                'label' => 'user.name',
            ))
            ->add('phone', 'text', array(
                'label' => 'Phone',
            ))
            ->add('question', 'text', array(
                'label' => 'Question',
            ))
            ->add('comment', 'text')
            ->add('answeredAt', 'datetime', array(
                'label' => 'Answer Date',
            ))
            ->add('refererLink', TextToLinkType::class, array(
                'label' => 'Referer Link',
                'admin' => $this,
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $userId = 1;
        $configure = $this->modelManager
            ->getEntityManager(CmfConfigure::class)
            ->getRepository(CmfConfigure::class);
        $fields = $configure->getConfigureFields($userId, $this->getClassnameLabel());

        foreach ($fields as $v) {
            if ($v['isVisuality']) {
                if ($v['fieldName'] == 'refererLink') {
                    $listMapper->add($v['fieldName'], 'url', [
                        'template' => 'admin/list_fields/referer_link.html.twig'
                    ]);
                } elseif ($v['fieldName'] == 'clinic') {
                    $listMapper->add($v['fieldName'], 'url', [
                        'template' => 'admin/list_fields/clinics_link.html.twig'
                    ]);
                } else {
                    $listMapper->add($v['fieldName']);
                }
            }
        }
        
        $listMapper->add('_action', null, array('actions' => array('show' => array())));
    }
}
