<?php

namespace App\Http\Controllers;

use App\Enums\Http\HttpStatusCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class Controller
{
    /**
     * @return JsonResponse|Response
     */
    protected function error(string|array $message, HttpStatusCode $code = HttpStatusCode::BAD_REQUEST): JsonResponse
    {
        return $this->response($message, $code, false);
    }

    protected function success(string|array|null $message = null, HttpStatusCode $code = HttpStatusCode::OK): JsonResponse|Response
    {
        return $this->response($message, $code);
    }

    protected function response(string|array|null $message, HttpStatusCode $code, bool $success = true): JsonResponse|Response
    {
        if ($code === HttpStatusCode::NO_CONTENT) {
            return response()->noContent();
        }

        if (is_array($message)) {
            return response()->json($message, $code->value);
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ], $code->value);
    }
}
