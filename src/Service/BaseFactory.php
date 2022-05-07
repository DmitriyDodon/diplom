<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

abstract class BaseFactory
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}