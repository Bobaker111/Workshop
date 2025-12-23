<?php

namespace App\Http\Requests\Api\V1\Account;

use App\Enums\Api\V1\Permissions;
use App\Enums\Api\V1\Roles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UpdateAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user?->hasRole(Roles::SUPER_ADMIN) || ($user?->hasPermissionTo(Permissions::UPDATE_ACCOUNT) && $user->id === $this->account->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['string', 'regex:/^0[5-7]{8}$/', 'unique:users'],
            'password' => ['confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
            'role' => [new Enum(Roles::class)],
            'is_active' => ['boolean'],
        ];
    }
}
