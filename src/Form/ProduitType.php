<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                "label" => "Nom du produit ",
                "constraints" => [
                    new NotBlank([
                        "message" => "Le nom ne peut être vide"
                    ])
                ]
            ])
            ->add('couleur', TextType::class,[
                "required" => false,
            ])
            ->add('photo', FileType::class, [
                "mapped" => false,
                "required" => false,
                "constraints" => [
                    new File([
                        "mimeTypes" => [ "image/gif", "image/jpeg", "image/png"], 
                        "mimeTypesMessage" => "Les formats autorisés sont gif, jpeg et png",
                        "maxSize" => "2048k",
                        "maxSizeMessage" => "Le fichier ne peut pas faire plus de 2Mo"
                    ])
                ]
            ])
            ->add('Flux', TextType::class,[
                "required" => false,
            ])
            ->add('Watt', TextType::class,[
                "required" => false,
            ])
            ->add('Tdecouleur', TextType::class, [
                "label" => "Température de couleur",
                "required" => false,
            ])
            ->add('Classe', ChoiceType::class,[
                "choices" => [
                    "I" => "I",
                    "II" => "II",
                    "III" => "III",
                ],
                "placeholder" => "",
                "multiple" => false,
                "required" => false,
                // "expanded" => true, la maniere dont les choix s'affiche
            ])
            ->add('Energieclass', FileType::class, [
                "label" => "Classe énergétique",
                "mapped" => false,
                "required" => false,
                "constraints" => [
                    new File([
                        "mimeTypes" => [ "image/gif", "image/jpeg", "image/png"], 
                        "mimeTypesMessage" => "Les formats autorisés sont gif, jpeg et png",
                        "maxSize" => "2048k",
                        "maxSizeMessage" => "Le fichier ne peut pas faire plus de 2Mo"
                    ])
                ]
            ])
            ->add('Fonction', FileType::class, [
                "label" => "Fonctions",
                "mapped" => false,
                "required" => false,
                // "multiple" => true,
                "constraints" => [
                    new File([
                        "mimeTypes" => [ "image/gif", "image/jpeg", "image/png"], 
                        "mimeTypesMessage" => "Les formats autorisés sont gif, jpeg et png",
                        "maxSize" => "2048k",
                        "maxSizeMessage" => "Le fichier ne peut pas faire plus de 2Mo"
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Descritpion",
                "required" => false,
            ])
            ->add("categories", EntityType::class,[
                "class" => Categorie::class,
                "choice_label" => "name",
                "placeholder" => "",
                "multiple" => true,
                "expanded" => true,
            ])
            ->add("enregistrer", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
