<?php

namespace App\Http\Requests\Api\V1\Account;

use App\Enums\Api\V1\Permissions;
use App\Enums\Api\V1\Roles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class CreateAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasPermissionTo(Permissions::CREATE_ACCOUNT);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required_without:phone_number', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required_without:email', 'string', 'regex:/^0[5-7]{8}$/', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
            'role' => ['required', 'string', new Enum(Roles::class)],
        ];
    }
}
