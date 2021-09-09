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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $users = $this->security->getUser();

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
                'data' => 90,
            ])
            ->add('descriptioninfos', TextareaType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('ville', EntityType::class, [
                'mapped' => false,
                'class' => Ville::class,
                'choice_label' => 'nom',
                'placeholder' => 'Ville'
            ])
            ->add('lieu', ChoiceType::class, [
                'placeholder' => 'Lieu (choisir une ville)',
            ]);
        /*$formModifier = function (FormInterface $form, Ville $ville = null) {
            $lieux = (null === $ville) ? [] : $ville->getLieux();
            $form->add('lieux', EntityType::class, [
                'class' => Lieu::class,
                'choices' => $lieux,
                'choice_label' => 'nom',
                'placeholder' => 'Lieu (choisir une ville)',
                'label' => 'lieu',
            ]);
        };
        $builder->get('ville')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $ville = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $ville);
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
