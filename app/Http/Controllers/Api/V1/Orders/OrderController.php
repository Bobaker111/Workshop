<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Orders\CreateOrderRequest;
use App\Http\Requests\Api\V1\Orders\ListOrdersRequest;
use App\Http\Requests\Api\V1\Orders\ShowOrderRequest;
use App\Http\Requests\Api\V1\Orders\UpdateOrderRequest;
use App\Http\Resources\Api\V1\Orders\OrderResource;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ListOrdersRequest $request): ResourceCollection
    {
        $orders = $request->user()->orders()->paginate($request->input('per_page', 25));

        return OrderResource::collection($orders);
    }

    /**
     * @return OrderResource
     */
    public function show(ShowOrderRequest $request, Order $order): JsonResource
    {
        $order->load('items', 'trip');

        return new OrderResource($order);
    }

    /**
     * @return OrderResource
     */
    public function store(CreateOrderRequest $request)
    {
        // TODO: attach trip
        $user = $request->user();
        $order = new Order;
        $order->user()->associate($user);
        $order->save();

        $items = collect($request->input('items'))
            ->mapWithKeys(fn ($item) => [$item['product_id'] => [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]]
            );
        $order->items()->attach($items);
        $order->load('items', 'trip');

        return new OrderResource($order);
    }

    /**
     * @return OrderResource
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResource
    {
        // TODO: change order status...

        $items = collect($request->input('items'))->mapWithKeys(function ($item) {
            return [$item['id'] => ['quantity' => $item['quantity']]];
        });
        $order->items()->sync($items);

        $order->load('items', 'trip');

        return new OrderResource($order);
    }
}
