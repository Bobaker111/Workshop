<?php

namespace App\Http\Requests\Api\V1\Accounts;

use App\Enums\Api\V1\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user?->isDriver() && $user?->hasPermissionTo(Permissions::UPDATE_ACCOUNT);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.longitude' => ['required', 'numeric', 'between:-180,180'],
            '*.latitude' => ['required', 'numeric', 'between:-90,90'],
        ];
    }
}
