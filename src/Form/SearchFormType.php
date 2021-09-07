<?php

namespace App\Form;

use App\Data\SearchData;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'translation_domain' => false,
            ])
            ->add('startDate', DateType::class, [
                'label' =>'Entre : ',
                'required' => false,
                'html5' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'to'],
                'translation_domain' => false,
            ])
            ->add('endDate', DateType::class, [
                'label' =>'Et : ',
                'required' => false,
                'html5' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'to'],
                'translation_domain' => false,
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'required' => false,
                'choice_label' => 'nom',
                'translation_domain' => false,
            ]);

     /* A afficher en mode connecte
     ->add('status', ChoiceType::class, [
            'choices' => [
                'Sorties dont je suis l\'organisateur/trice' => 'organisateur',
                'Sorties auxquelles je suis inscrit/e' => 'inscrit',
                'Sorties auxquelles je ne suis pas inscrit/e' => 'noinscrit',
                'Sorties passées' => 'passees',
            ],
            'label' => false,
            'required' => false,
            'expanded' => true,
            'multiple' => true,
            'data' => ['organisateur', 'inscrit', 'noinscrit'],
            ]);*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
        ]);
    }

}