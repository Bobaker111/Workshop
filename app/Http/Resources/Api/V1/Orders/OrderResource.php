<?php

namespace App\Http\Resources\Api\V1\Orders;

use App\Http\Resources\Api\V1\Products\ProductResource;
use App\Http\Resources\Api\V1\TripResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'trip' => new TripResource($this->whenLoaded('trip')),
            'items' => ProductResource::collection($this->whenLoaded('items')),
            'created_at' => $this->created_at,
        ];
    }
}
