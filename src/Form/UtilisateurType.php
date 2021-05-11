<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UtilisateurType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('pseudo', TextType::class, ['label' => 'Pseudo'])
            ->add('email', EmailType::class, ['label' => 'Adresse e-mail'])
            ->add('anneenaissance', IntegerType::class, ['label' => 'Année de naissance'])
            ->add('avatar', FileType::class, ['label' => 'Avatar'])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Entrez votre mot de passe'],
                'second_options' => ['label' => 'Confirmez votre mot de passe']
                ])
            ->add('save', SubmitType::class, ['label' => "S'enregistrer"]);
    }
}
