<?php

namespace App\Services\Order;

use App\Enums\OrderStatusEnums;
use App\Models\Option;
use App\Models\Order;
use App\Models\Product;
use App\Models\Variation;

class CustomerCreateOrder
{
    /**
     * @param array $orderParams
     * @return Order
     */
    public function do(array $orderParams): Order
    {
        $purchasedProduct = Product::find($orderParams['product_id']);
        return Order::create([
            'product_id' => $purchasedProduct->id,
            'user_id'    => auth()->user()->id,
            'status'     => OrderStatusEnums::WAITING->value,
            'detail'     => Order::generateOrderDetailText($orderParams['variations']),
            'price'      => $purchasedProduct->price
        ]);
    }
}
