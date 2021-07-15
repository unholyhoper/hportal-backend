<?php
namespace App\Form;
use App\Entity\Material;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null,['required' => false])
            ->add('name', null,['required' => false])
            ->add('type',null, ['required' => false])
            ->add('quantity',null, ['required' => false])
            ->add('image',null, ['required' => false])
            ->add('save', SubmitType::class)
        ;

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Material::class,
            'csrf_protection' => false,
//            'allow_extra_fields' => true,
        ));
    }
}