<?php

namespace App\Http\Controllers\Api\V1\Chat;

use App\Events\Api\V1\Chat\MessageCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Chat\ListMessagesRequest;
use App\Http\Requests\Api\V1\Chat\StoreMessageRequest;
use App\Http\Resources\Api\V1\Chat\MessageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageController extends Controller
{
    public function index(ListMessagesRequest $request): ResourceCollection
    {
        $user = $request->user();
        $messages = $user->messages()->simplePaginate();

        return MessageResource::collection($messages);
    }

    public function store(StoreMessageRequest $request): JsonResource
    {
        $user = $request->user();
        $message = $user->messages()->create($request->validated());
        MessageCreated::dispatch(); // TODO: Use sockets

        return new MessageResource($message);
    }
}
