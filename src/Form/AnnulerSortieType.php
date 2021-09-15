<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sorties;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnulerSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom', TextType::class, [
            'label' => false,
        ])
            ->add('datedebut', DateType::class, [
                'label' => false,
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('siteOrganisateur', EntityType::class, [
                'label' => false,
                'class' => Campus::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => function (Campus $campus) {
                    return $campus->getNom();
                }
            ])
            ->add('lieu', EntityType::class, [
                'label' => false,
                'class' => Lieu::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l');
                },
                'choice_label' => function (Lieu $lieu) {
                    return $lieu->getNom();
                }
            ])
            ->add('descriptioninfos', TextareaType::class, [
                'label' => false,
                'required' => false,
            ]);

         }
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => Sorties::class,
                'translation_domain' => false,
            ]);
        }
    }