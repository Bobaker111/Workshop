<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\Api\V1\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Register a new user
     */
    public function register(RegisterUserRequest $request, Roles $role): UserResource
    {
        $user = User::create($request->validated());
        $user->assignRole($role);
        $token = $user->createToken('auth-token')->plainTextToken;

        return (new UserResource($user))->additional(['token' => $token]);
    }
}
