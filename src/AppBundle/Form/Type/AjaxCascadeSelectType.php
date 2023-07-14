<?php

namespace AppBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AjaxCascadeSelectType
 *
 * Класс для построения цепочки взаимосвязанных селектов.
 * Основан на связях между сущностями.
 * Служит для облегчения выбора элемента, путем сужения количества возможных вариантов
 */
class AjaxCascadeSelectType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var AbstractAdmin произвольный админ-класс, являющийся потомком AbstractAdmin
     */
    private $class;

    /**
     * AjaxCascadeSelectType constructor.
     *
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'binding' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['binding'] = $options['binding'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //dump($options);
        $this->class = $this->getAdmin($options)->getClass();
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TextType::class;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'ajax_cascade_select';
    }

    /**
     * {@inheritdoc}
     */
    protected function getFieldDescription(array $options)
    {
        if (!isset($options['sonata_field_description'])) {
            throw new \RuntimeException('Please provide a valid `sonata_field_description` option');
        }

        return $options['sonata_field_description'];
    }

    /**
     * @param array $options
     *
     * @return mixed произвольный админ-класс, являющийся потомком AbstractAdmin
     */
    protected function getAdmin(array $options)
    {
        return $this->getFieldDescription($options)->getAssociationAdmin();
    }
}
