<?php

namespace App\Services\Order\Modify;

use App\Models\Order;

interface OrderModifyInterface
{
    /**
     * @return Order
     */
    public function do(): Order;
}
