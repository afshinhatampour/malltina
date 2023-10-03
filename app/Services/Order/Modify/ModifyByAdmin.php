<?php

namespace App\Services\Order\Modify;

use App\Models\Order;

class ModifyByAdmin implements OrderModifyInterface
{
    /**
     * @param Order $order
     * @param array $request
     */
    public function __construct(private readonly Order $order, private readonly array $request)
    {
    }

    /**
     * @return Order
     */
    public function do(): Order
    {
        $this->order->update(['status' => $this->request['status']]);
        return $this->order;
    }
}
