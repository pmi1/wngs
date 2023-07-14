<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Catalogue;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Form\Type\AjaxCascadeSelectType;
use Symfony\Component\Form\CallbackTransformer;

/**
 * Class ItemCatalogueAdmin
 */
class ItemCatalogueAdmin extends ListCommonAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->isCurrentRoute('create', 'admin.catalogue')
            || $this->isCurrentRoute('edit', 'admin.catalogue')
            || $this->getRequest()->query->get('code') === 'admin.catalogue') {
            $formMapper->add('item', 'sonata_type_model', array());
        } else {
            $formMapper->add('catalogue', ChoiceType::class, array(
                    'choice_label' => function($category, $key, $value) {
                        return sprintf('%s %s', str_repeat('-', $category->getDepth()-1), $category->getName());
                    },
                    'choices'  => $this->modelManager
                            ->getEntityManager(Catalogue::class)
                            ->getRepository(Catalogue::class)->findBy([], ['leftMargin' => 'ASC']),
                ));
        }
    }
}
