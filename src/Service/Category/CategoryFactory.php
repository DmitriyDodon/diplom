<?php

namespace App\Service\Category;

use App\Entity\Category;

class CategoryFactory
{
  public static function createCategory(
      string $title
  ): Category
  {
      $category = new Category();
      $category->setTitle($title);
      $category->setSlug();

      return $category;
  }
}