<?php

namespace App\Form;

use App\Entity\Biens;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BiensType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('prix')
            ->add('type', ChoiceType::class, [
                "choices" => Biens::TYPE,
            ])
            ->add('zone')
            ->add('typeUsage', ChoiceType::class, [
                "choices" => Biens::TYPEU,
            ])
            ->add('loyer')
            ->add('periode')
            ->add('photo')
            ->add('bienImage', FileType::class, [
                'label'=> false,
                'multiple' => true,
                'required' => false,
                'mapped' => false
            ])
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
            'data_class' => Biens::class,
        ]);
    }
}
