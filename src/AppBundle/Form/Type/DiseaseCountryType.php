<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Admin\DiseaseAdmin;
use AppBundle\Entity\Disease;

/**
 * Class DiseaseCountryType
 *
 * Типы стран заболевания
 */
class DiseaseCountryType extends AbstractType
{
    /**
     * @var DiseaseAdmin
     */
    private $admin;

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $repo = $this->admin->getConfigurationPool()->getContainer()->get('doctrine')->getRepository(Disease::class);
        $view->vars['attributs'] = $repo->getCountryList($this->admin->id($this->admin->getSubject()));
        $view->vars['value'] = $repo->getDiseaseCountry($this->admin->id($this->admin->getSubject()));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->admin = clone $options['admin'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'admin' => array(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TextType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'disease_country_type';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
