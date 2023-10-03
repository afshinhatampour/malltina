<?php

namespace App\Http\Controllers\Api\V1\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Shop\Order\StoreOrderRequest;
use App\Http\Requests\Shop\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Services\Order\CustomerCreateOrder;
use App\Services\Order\Modify\OrderModifyFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class OrderController extends ApiController
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return $this->success('', Order::authUserOrders()->paginate(self::PER_PAGE));
    }

    /**
     * @param StoreOrderRequest $request
     * @param CustomerCreateOrder $createOrder
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request, CustomerCreateOrder $createOrder): JsonResponse
    {
        return $this->success(trans('order.customer.store'), $createOrder->do($request->validated()),
            HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order)
    {
        Gate::authorize('isOwnerOfOrder', $order);
        return $this->success('', $order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        Gate::authorize('isOwnerOfOrder', $order);
        (OrderModifyFactory::make('user', $order, $request->validated()))->do();
    }
}
