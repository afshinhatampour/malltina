<?php

namespace App\Services\Order\Modify;

use App\Events\OrderStatusChangeEvent;
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
        $this->order->status === $this->request['status'] ?: $this->changeOrderStatus();

        return $this->order;
    }

    /**
     * we can check order status change in order observer but personally prefer to don't use observer in project
     * because observe can bring so much headache in logic
     * @return void
     */
    protected function changeOrderStatus(): void
    {
        $this->order->update(['status' => $this->request['status']]);
        event(new OrderStatusChangeEvent($this->order));
    }
}
