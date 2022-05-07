<?php

namespace App\Service\Order;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Service\BaseManager;

class OrderManager extends BaseManager
{
    public function getRightValuesForOrder(Order $order)
    {
        $grandTotal = 0;
        if ($order->getItems()){
            $grandTotal = $order->getItems()->map(function (OrderItem $orderItem){
                return $orderItem->getPrice() - $orderItem->getDiscount();
            });
            $grandTotal = array_sum($grandTotal->toArray());
        }
        $order->setGrandTotal($grandTotal);
        $grandDiscount = 0;
        if ($order->getItems()){
            $grandDiscount = $order->getItems()->map(function (OrderItem $orderItem){
                return $orderItem->getDiscount();
            });
            $grandDiscount = array_sum($grandDiscount->toArray());
        }
        $order->setDiscount($grandDiscount);
    }
}