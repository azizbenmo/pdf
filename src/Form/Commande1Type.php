<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Livreur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class Commande1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statutCommande', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le statut de la commande ne peut pas être vide.']),
                    new Assert\Choice([
                        'choices' => ['En attente', 'En cours', 'Livrée', 'Annulée'],
                        'message' => 'Choisissez un statut valide (En attente, En cours, Livrée, Annulée).',
                    ]),
                ],
                'label' => 'Statut de la commande'
            ])
            ->add('dateCommande', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La date de la commande est requise.']),
                    new Assert\Date(['message' => 'Veuillez entrer une date valide.']),
                    new Assert\LessThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date de commande ne peut pas être dans le futur.'
                    ])
                ],
                'label' => 'Date de la commande'
            ])
            ->add('produit', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom du produit est obligatoire.']),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Le nom du produit ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                ],
                'label' => 'Produit'
            ])
            ->add('prix', NumberType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le prix est obligatoire.']),
                    new Assert\Positive(['message' => 'Le prix doit être un nombre positif.']),
                ],
                'label' => 'Prix'
            ])
            ->add('livreur', EntityType::class, [
                'class' => Livreur::class,
                'choice_label' => 'id',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez sélectionner un livreur.']),
                ],
                'label' => 'Livreur'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}

