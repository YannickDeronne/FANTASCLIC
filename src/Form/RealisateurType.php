<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RealisateurType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
            ])
            ->add('nom', TextType::class, ['label' => 'Nom'])
            ->add('anneeNaissance', IntegerType::class, [
                'label' => 'Année de naissance',
                'required' => false,
                'attr' => ['min' => 1800],
            ])
            ->add('anneeDeces', IntegerType::class, [
                'label' => 'Année de décès',
                'required' => false,
                'attr' => ['min' => 1895],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Déscription',
                'required' => false,
                'attr' => [
                    'rows' => 10,
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Sauvegarder']);
    }
}
