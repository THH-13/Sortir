<?php

namespace App\Form;

use App\Data\SearchData;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => 'Le nom de la sortie contient : ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'search'
                ],
            ])
            ->add('startDate', DateType::class, [
                'label' =>'Entre : ',
                'required' => false,
                'html5' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'to'],
            ])
            ->add('endDate', DateType::class, [
                'label' =>'Et : ',
                'required' => false,
                'html5' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'to'],
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'required' => false,
                'choice_label' => 'nom',
            ])
            ->add('sortiesOrganisateur', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'data' => true,
            ])
            ->add('sortiesInscrit', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'data' => true,
            ])
            ->add('sortiesNoInscrit', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'data' => true,
            ])

            ->add('sortiesPassees', CheckboxType::class, [
                'label' => false,
                'required' => false,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'translation_domain' => false,
        ]);
    }

}