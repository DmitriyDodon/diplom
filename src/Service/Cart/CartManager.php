<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Service\BaseManager;

class CartManager extends BaseManager
{
    public function deleteAllItemsFromCart(Cart $cart)
    {
        foreach ($cart->getItems() as $cartItem)
        {
            $this->getRepository(CartItem::class)->remove($cartItem);
        }
    }
}