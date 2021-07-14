<?php
namespace App\Form;
use App\Entity\Medecine;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null,['required' => false])
            ->add('reference', null,['required' => false])
            ->add('manufacturer',null, ['required' => false])
            ->add('quantity',null, ['required' => false])
            ->add('expirationDate',null, ['required' => false])
            ->add('price',null, ['required' => false])
            ->add('image',null, ['required' => false])
            ->add('save', SubmitType::class)
        ;

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Medecine::class,
            'csrf_protection' => false,
//            'allow_extra_fields' => true,
        ));
    }
}