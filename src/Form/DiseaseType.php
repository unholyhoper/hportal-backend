<?php
namespace App\Form;
use App\Entity\Disease;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class
DiseaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null,['required' => false])
            ->add('name', null,['required' => false])
            ->add('description', null,['required' => false]);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Disease::class,
            'csrf_protection' => false,
//            'allow_extra_fields' => true,
        ));
    }
}