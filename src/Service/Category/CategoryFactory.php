<?php

namespace App\Service\Category;

use App\Entity\Category;
use Ausi\SlugGenerator\SlugGenerator;
use Ausi\SlugGenerator\SlugGeneratorInterface;
use Ausi\SlugGenerator\SlugOptions;
use Doctrine\ORM\EntityManagerInterface;

class CategoryFactory
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

    public function createCategory(
        string $title,
        string $content = null,
        string $metaTitle = null
    ): Category {
        $slug = $this->slugGenerator->generate($title);
        $category = new Category();
        $category->setTitle($title);
        $category->setSlug($slug);
        $category->setContent($content);
        $category->setMetaTitle($metaTitle);
        $this->em->persist($category);
        $this->em->flush();
        return $category;
    }
}