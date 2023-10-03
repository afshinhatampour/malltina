<?php

namespace App\Services\Order\Modify;

use App\Enums\OrderStatusEnums;
use App\Models\Option;
use App\Models\Order;
use App\Models\Variation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ModifyByUser implements OrderModifyInterface
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
        if ($this->order->status === OrderStatusEnums::WAITING->value) {
            $orderNewParams = [
                'product_id' => $this->request['product_id'],
                'status'     => $this->request['status'] ?? $this->order->status,
                'detail'     => Order::generateOrderDetailText($this->request['variations'])
            ];

            $this->order->update($orderNewParams);
        }

        return $this->order;
    }
}
