<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

abstract class BaseManager
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getRepository(string $className)
    {
        return $this->entityManager->getRepository($className);
    }
}