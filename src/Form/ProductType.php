<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageUrl')
            ->add('title')
            ->add('metaTitle')
            ->add('slug')
            ->add('summary')
            ->add('type')
            ->add('sky')
            ->add('price')
            ->add('discount')
            ->add('shop')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('publishedAt')
            ->add('startsAt')
            ->add('endsAt')
            ->add('content')
            ->add('user')
            ->add('categories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
