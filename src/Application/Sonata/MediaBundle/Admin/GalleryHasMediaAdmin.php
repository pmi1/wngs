<?php

namespace Application\Sonata\MediaBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

/*
 * Добавляем в стандартную галерею флаг "основное изображение"
 */
class GalleryHasMediaAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $link_parameters = array();

        if ($this->hasParentFieldDescription()) {
            $link_parameters = $this->getParentFieldDescription()->getOption('link_parameters', array());
        }

        if ($this->hasRequest()) {
            $context = $this->getRequest()->get('context', null);

            if (null !== $context) {
                $link_parameters['context'] = $context;
            }
        }

        // NEXT_MAJOR: Keep FQCN when bumping Symfony requirement to 2.8+
        $modelListType = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')
            ? 'Sonata\AdminBundle\Form\Type\ModelListType'
            : 'sonata_type_model_list';

        // NEXT_MAJOR: Keep FQCN when bumping Symfony requirement to 2.8+.
        $hiddenType = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')
            ? 'Symfony\Component\Form\Extension\Core\Type\HiddenType'
            : 'hidden';
        $img = '';
        
        if ($this->getSubject()) {
            $media = $this->getSubject()->getMedia();
            $img = $this->getConfigurationPool()->getContainer()->get('sonata.media.twig.extension')->path($media, 'reference');

            if ($img) {
                $img = '<img src="'.$img.'" class="admin-preview" width="150px"/>';
            }
        }
        
        $formMapper
            ->add('media', $modelListType, array('required' => false, 'sonata_help'=> $img), array(
                'link_parameters' => $link_parameters,
            ))
            ->add('enabled', null, array('required' => false))
            ->add('main', null, array('required' => false))
            ->add('position', $hiddenType)
        ;
    }
}
