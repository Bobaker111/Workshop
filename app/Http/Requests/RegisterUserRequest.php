<?php

namespace App\Http\Requests;

use App\Enums\Api\V1\Roles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array($this->role, Roles::cases()) && $this->role !== Roles::SUPER_ADMIN;
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
            'phone_number' => ['required_without:email', 'string', 'regex:/^[0-9]{10}$/', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
