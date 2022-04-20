<?php

namespace App\Service\Product;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Ausi\SlugGenerator\SlugGenerator;
use Ausi\SlugGenerator\SlugGeneratorInterface;
use Ausi\SlugGenerator\SlugOptions;
use Doctrine\ORM\EntityManagerInterface;

class ProductFactory
{
    private EntityManagerInterface $em;
    private SlugGeneratorInterface $slugGenerator;

    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
        $this->slugGenerator = new SlugGenerator((new SlugOptions)->setValidChars('a-zA-Z0-9')->setLocale('ua')->setDelimiter('_'));
    }

    public function createProduct(
        string $title,
        float $price,
        string $imageUrl,
        User $user,
        Category $category
    ): Product
    {
        $slug = $this->slugGenerator->generate($title);
        $product = new Product();
        $product->setImageUrl($imageUrl);
        $product->setSky(random_int(100, 100000));
        $product->setUser($user);
        $product->setTitle($title);
        $product->setSlug($slug);
        $product->setPrice($price);
        $product->setCreatedAt(new \DateTime('now'));
        $product->addCategory($category);
        $category->addProduct($product);
        $this->em->persist($product);
        $this->em->flush();
        return $product;
    }
}