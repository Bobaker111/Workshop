<?php

namespace App\Http\Controllers\Api\V1\Notifications;

use App\Enums\Http\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Notifications\DeleteNotificationRequest;
use App\Http\Requests\Api\V1\Notifications\ListNotificationsRequest;
use App\Http\Resources\Api\V1\Notifications\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ListNotificationsRequest $request): ResourceCollection
    {
        $user = $request->user();
        $notifications = $user->notifications()->simplePaginate();

        return NotificationResource::collection($notifications);
    }

    /**
     * @return Response|\Illuminate\Http\JsonResponse
     */
    public function delete(DeleteNotificationRequest $request, Notification $notification): Response
    {
        $notification->delete();

        return $this->success(code: HttpStatusCode::NO_CONTENT);
    }
}
