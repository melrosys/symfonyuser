<?php

namespace App\Form;

use App\Entity\Marque;
use App\Entity\Fournisseur;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            /*->add('id_catego', EntityType::class, [
            'class' => Category::class,
            'choice_label' => function (Category $catego) {
                return $catego->getName();
            }
        ])*/
            ->add('model')
            ->add('tags')
            ->add('marque', EntityType::class, [
            'class' => Marque::class,
            'choice_label' => function (Marque $marque) {
                return $marque->getName();
            }
        ])
            ->add('id_fourni', EntityType::class, [
            'class' => Fournisseur::class,
            'choice_label' => function (Fournisseur $fourn) {
                return $fourn->getSociete();
            }
        ])
            ->add('waranty', ChoiceType::class, [
            'choices'  => [
                'Choisir' => null,
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6,
            ],
        ])
            ->add('gest_sn', ChoiceType::class, [
            'choices'  => [
                'Choisir' => null,
                'oui' => "1",
                'non' => "0",
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            /*'data_class' => Product::class,*/
        ]);
    }
}
