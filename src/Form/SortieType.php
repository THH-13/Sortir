<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie : '
    ])
            ->add('datedebut', DateType::class, [
                'html5' => true,
                'widget' => 'single-text',
            ])

            ->add('datecloture', DateType::class, [
                'html5' => true,
                'widget' => 'single-text',
            ])
            ->add('nbinscriptionsmax')

            ->add('duree')

            ->add('descriptioninfos', null, [
                'required' => false,
            ])
            ->add('siteOrganisateur')
            ->add('lieu')
            ->add('etat')
          /*  ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'required' => false,
                'choice_label' => 'nom',
                'translation_domain' => false,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
