<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('prix')
            ->add('type', ChoiceType::class, [
                "choices" => Demande::TYPE,
            ])
            ->add('zone')
            ->add('typeUsage', ChoiceType::class, [
                "choices" => Demande::TYPEU,
            ])
            ->add('loyer')
            ->add('periode')
            ->add('photo')
            ->add('Enregistrer', SubmitType::class, [
                "attr"=>[
                    "class"=>"btn-primary ml-2 float-right"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
