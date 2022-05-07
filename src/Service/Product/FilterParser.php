<?php

namespace App\Service\Product;

use App\Service\FiltersDto\ProductFilter;
use Symfony\Component\HttpFoundation\RequestStack;

class FilterParser
{
    private RequestStack $requestStack;

    public function __construct(
        RequestStack $requestStack
    )
    {
        $this->requestStack = $requestStack;
    }

    public function parseRequest(): ProductFilter
    {
        $filter = new ProductFilter();

        $request = $this->requestStack->getCurrentRequest();

        if ($request && $categories = $request->get('categories', null)){
            $filter->setCategoryNames($categories);
        }

        return  $filter;
    }
}