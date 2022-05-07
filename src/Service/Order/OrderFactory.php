<?php

namespace App\Service\Order;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Service\BaseFactory;

class OrderFactory extends BaseFactory
{
    public function createOrder(Cart $cart)
    {
        $order = new Order();

        $totalDiscount = $cart->getItems()->map(function (CartItem $cartItem){
            return $cartItem->getDiscount() ?? 0;
        })->toArray();

        $order->setDiscount(array_sum($totalDiscount));

        $total = $cart->getItems()->map(function (CartItem $cartItem){
            return $cartItem->getPrice() ?? 0;
        })->toArray();

        $order->setSubTotal(array_sum($total) - $order->getDiscount());

        $order->setTax(random_int(1, 20));

        $order->setUser($cart->getUser());

        $order->setShipping(random_int(20, 30));

        $order->setTotal($order->getSubTotal() + $order->getSubTotal() * ($order->getTax() / 100));

        $order->setGrandTotal($order->getTotal() + $order->getShipping());

        $order->setCreatedAt(new \DateTime('now'));

        $order->setEmail($cart->getUser()->getEmail());

        $order->setFirstName($cart->getUser()->getFirstName());

        $order->setLastName($cart->getUser()->getLastName());

        $cart->getItems()->map(function (CartItem $cartItem) use ($order){
            $orderItem = new OrderItem();
            $orderItem->setCreatedAt(new \DateTime('now'));
            $orderItem->setDiscount($cartItem->getDiscount());
            $orderItem->setQuantity($cartItem->getQuantity());
            $orderItem->setPrice($cartItem->getPrice());
            $orderItem->setProduct($cartItem->getProduct());
            $orderItem->setOrder($order);
            $orderItem->setSku($cartItem->getSku());
            $this->entityManager->persist($orderItem);
            $order->addOrderItem($orderItem);
        });

        $this->entityManager->persist($order);

        return $order;
    }
}