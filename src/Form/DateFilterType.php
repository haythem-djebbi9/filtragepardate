<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',  // Afficher comme un champ de date unique
                'label' => 'Start Date',    // Libellé du champ
                'required' => false,        // Le champ peut être facultatif
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',  // Afficher comme un champ de date unique
                'label' => 'End Date',      // Libellé du champ
                'required' => false,        // Le champ peut être facultatif
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Filter',        // Libellé du bouton de soumission
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Pas d'entité associée, car c'est un simple formulaire de recherche
        ]);
    }
}
