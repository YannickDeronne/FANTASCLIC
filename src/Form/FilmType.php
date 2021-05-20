<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Genre;
use App\Entity\Realisateur;
use App\Entity\SJ;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class FilmType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('titre', TextType::class, ['label' => 'Titre'])

            ->add('annee', IntegerType::class, ['label' => 'Année',
                'required' => false,
                'attr' => ['min' => 1895, 'max' => 2021]])
                // a modifier selon l'année d'utilisation 

            ->add('genre', EntityType::class, ['label' => 'Genre',
                'required' => false,
                'class' => Genre::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true])

            ->add('duree', IntegerType::class, ['label' => 'Durée en minutes',
                'required' => false,
                'attr' => ['min' => 1]])

            ->add('realisateur', EntityType::class, ['label' => 'Réalisateur',
                'class' => Realisateur::class,
                'choice_label' => function ($realisateur) {
                    return $realisateur->getPrenom() . " " . $realisateur->getNom();}])

            ->add('casting', TextareaType::class, ['label' => 'Casting',
                'required' => false,
                'attr' => ['rows' => 3]])

            ->add('sj', EntityType::class, ['label' => 'Signalétique jeunesse',
                'required' => false,
                'class' => SJ::class,
                'choice_label' => 'sj'])

            ->add('synopsis', TextareaType::class, ['label' => 'Synopsis',
                'required' => false,
                'attr' => ['rows' => 5]])

            ->add('noteadmin', IntegerType::class, ['label' => 'Note admin',
                'required' => false,
                'attr' => ['min' => 0, 'max' => 20]])

            ->add('dispo', TextType::class, ['label' => 'Disponible sur',
                'required' => false])

            ->add('bandeannonce', UrlType::class, ['label' => 'Bande-annonce',
                'required' => false])

            ->add('ost', UrlType::class, ['label' => 'OST',
                'required' => false])

            ->add('affiche', TextType::class, ['label' => 'Affiche',
                'required' => false])

            ->add('affiche', FileType::class, ['label' => 'Affiche (fichier JPEG)',
                                                'mapped' => false,
                                                'required' => false,
                                                'constraints' => [new File(['maxSize' => '1024k',
                                                                        'mimeTypes' => ['image/jpeg'],
                                'mimeTypesMessage' => 'Veuillez choisir une image valide en format JPEG'])]])

            ->add('suggestion', EntityType::class, ['label' => 'Vous avez aimé ce film, vous pourriez aimer',
                'required' => false,
                'class' => Film::class,
                'choice_label' => 'titre',
                'multiple' => true,
                'expanded' => true])

            ->add('save', SubmitType::class, ['label' => 'ENREGISTRER CE FILM']);
    }
}
