<?php

namespace App\Services\Order\Modify;

use App\Models\Order;

class OrderModifyFactory
{
    /**
     * @param string $type
     * @param Order $order
     * @return OrderModifyInterface
     */
    public static function make(string $type, Order $order, array $request): OrderModifyInterface
    {
        return match (strtolower($type)) {
          'user' => new ModifyByUser($order, $request),
          'admin' => new ModifyByAdmin($order, $request)
        };
    }
}
