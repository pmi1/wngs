<?
namespace AppBundle\Type;

use AppBundle\Entity\Attribute;
use AppBundle\Entity\ItemAttribute;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ItemAttributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) { 
            $entity = $event->getData(); 
            $form = $event->getForm();
            $form
                ->add('value', TextType::class, [
                    'required' => false, 
                    'label' => $entity->getAttribute()->getName()
                ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ItemAttribute::class
        ));
    }
}