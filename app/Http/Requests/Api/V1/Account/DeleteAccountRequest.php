<?php

namespace App\Http\Requests\Api\V1\Account;

use App\Enums\Api\V1\Permissions;
use App\Enums\Api\V1\Roles;
use Illuminate\Foundation\Http\FormRequest;

class DeleteAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user?->hasRole(Roles::SUPER_ADMIN) || ($user?->hasPermissionTo(Permissions::DELETE_ACCOUNT) && $user->id === $this->account->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
