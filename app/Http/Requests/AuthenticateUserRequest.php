<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AuthenticateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required_without:phone_number', 'string', 'email', 'max:255'],
            'phone_number' => ['required_without:email', 'string', 'regex:/^[0-9]{10}$/'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required_without' => 'Either email or phone is required.',
            'phone_number.required_without' => 'Either email or phone is required.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->email && $this->phone_number) {
                $validator->errors()->add('email', 'Cannot provide both email and phone.');
                $validator->errors()->add('phone_number', 'Cannot provide both email and phone.');
            }
        });
    }

    public function user($guard = null): User
    {
        return User::when($this->email, fn ($query) => $query->where('email', $this->email))
            ->when($this->phone_number, fn ($query) => $query->where('phone_number', $this->phone_number))
            ->firstOrFail();
    }
}
