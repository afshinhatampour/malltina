<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Events\OrderStatusChangeEvent;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Services\Order\Modify\OrderModifyFactory;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends ApiController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(trans('order.admin.index'), Order::paginate(self::PER_PAGE));
    }

    /**
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        return $this->success(trans('order.admin.show') ,$order);
    }

    /**
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        (OrderModifyFactory::make('admin', $order, $request->validated()))->do();
        return $this->success(trans('order.admin.update'), []);
    }

    /**
     * @param Order $order
     * @return JsonResponse
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();
        return $this->success(trans('order.admin.destroy'), []);
    }
}
