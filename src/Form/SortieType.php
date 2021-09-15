<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sorties;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class SortieType extends AbstractType
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
            ->add('datecloture', DateType::class, [
                'label' => false,
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('nbinscriptionsmax', IntegerType::class, [
                'label' => false,
            ])
            ->add('duree', IntegerType::class, [
                'label' => false,
            ])
            ->add('descriptioninfos', TextareaType::class, [
                'label' => false,
                'required' => false,
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
            ->add('lieuLatitude', EntityType::class, [
                'mapped' => false,
                'label' => false,
                'class' => Lieu::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l');
                },
                'choice_label' => function (Lieu $lieu) {
                    return $lieu->getLatitude();
                }
            ])
            ->add('lieuLongitude', EntityType::class, [
                'mapped' => false,
                'label' => false,
                'class' => Lieu::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l');
                },
                'choice_label' => function (Lieu $lieu) {
                    return $lieu->getLongitude();
                }
            ])
            ->add('ville', EntityType::class, [
                'mapped' => false,
                'label' => false,
                'class' => Ville::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v');
                },
                'choice_label' => function (Ville $ville) {
                    return $ville->getNom();
                }
            ])
            ->add('lieuRue', EntityType::class, [
                'mapped' => false,
                'label' => false,
                'class' => Lieu::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l');
                },
                'choice_label' => function (Lieu $lieu) {
                    return $lieu->getRue();
                }
            ])
            ->add('villeCodePostal', EntityType::class, [
                'mapped' => false,
                'label' => false,
                'class' => Ville::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v');
                },
                'choice_label' => function (Ville $ville) {
                    return $ville->getCodePostal();
                }
            ])
           ->add('publier', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ])
            ->add('supprimer', SubmitType::class, [

                /*'attr' => ['class' => 'save'],*/

            ]);/* ->add('organisateur', HiddenType::class, [
            'data'=> '$id'
        ])*/;

        /*$builder->get('villeNom')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();

                $form->getParent()->add('lieu', EntityType::class, [
                    /*'mapped' => false,*/
        /*  'class' => Lieu::class,
          'placeholder' => 'Please select lieu',
          'choices' => $form->getData()->getLieux()

      ]);
  }
);*/


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
            'translation_domain' => false,
        ]);
    }
}
