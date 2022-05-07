<?php

namespace App\Service\CartItem;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Service\BaseFactory;

class CartItemFactory extends BaseFactory
{

     public function createCartItem(Product $product, Cart $cart, int $quantity = 1)
     {
         $cartItem = $cart->getItems()->filter(function (CartItem $cartItem) use ($product, $quantity) {
             if ($cartItem->getProduct() === $product) {
                 $cartItem->setPrice($cartItem->getPrice() + $product->getPrice());
                 $cartItem->setDiscount($cartItem->getDiscount() + $product->getDiscount());
                 $cartItem->setQuantity($cartItem->getQuantity() + $quantity);
                 return $cartItem;
             }
         })->first();

         if ($cartItem){
             $this->entityManager->flush();
             return $cartItem;
         }

         $cartItem = new CartItem();
         $cartItem->setProduct($product);
         $cartItem->setCart($cart);
         $cartItem->setSku(random_int(1,10));
         $cartItem->setCreatedAt(new \DateTime('now'));
         $cartItem->setDiscount($product->getDiscount());
         $cartItem->setPrice($product->getPrice());
         $cartItem->setQuantity($quantity);
         $this->entityManager->persist($cartItem);
         $this->entityManager->flush();
         return $cartItem;
     }
}