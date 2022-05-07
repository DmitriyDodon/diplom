<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CartFactory
{
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    public function createCart(User $user)
    {
        $cart = new Cart();
        $cart->setCreatedAt(new \DateTime('now'));
        $this->em->persist($cart);
        $this->em->flush();
        return $cart;
    }
}