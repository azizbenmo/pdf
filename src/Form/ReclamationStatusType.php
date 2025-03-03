<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('statutRec', ChoiceType::class, [
            'label' => 'Statut',
            'choices' => [
                'En attente' => Reclamation::STATUS_EN_ATTENTE,
                'En cours' => Reclamation::STATUS_EN_COURS,
                'Résolu' => Reclamation::STATUS_RESOLU,
                'Fermé' => Reclamation::STATUS_FERME
            ],
            'placeholder' => 'Sélectionnez un statut'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
