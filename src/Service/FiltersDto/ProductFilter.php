<?php

namespace App\Service\FiltersDto;

class ProductFilter
{
    private ?array $categoryNames = [];

    /**
     * @return array|null
     */
    public function getCategoryNames(): ?array
    {
        return $this->categoryNames;
    }

    /**
     * @param array|null $categoryNames
     */
    public function setCategoryNames(?array $categoryNames): void
    {
        $this->categoryNames = $categoryNames;
    }



}