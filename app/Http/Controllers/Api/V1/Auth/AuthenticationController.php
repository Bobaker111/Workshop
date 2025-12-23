<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    /**
     * Login a user
     *
     * @return JsonResponse|mixed
     */
    public function login(AuthenticateUserRequest $request): JsonResource
    {
        $credentials = $request->only(['email', 'phone_number', 'password']);

        // Remove null values from credentials
        $credentials = array_filter($credentials, fn ($value) => $value !== null);

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('auth-token')->plainTextToken;

        return new UserResource($user)->additional(['token' => $token]);
    }

    /**
     * Logout a user
     *
     * @return JsonResponse|mixed
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function deleteAccount(Request $request): JsonResponse
    {
        $request->user()->delete();

        return response()->json(['message' => 'Account deleted successfully']);
    }

    public function updateAccount(UpdateAccountRequest $request): UserResource
    {
        $user = $request->user();
        $user->fill($request->validated());
        $user->save();

        return new UserResource($user);
    }
}
