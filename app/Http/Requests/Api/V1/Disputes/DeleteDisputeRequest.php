<?php

namespace App\Http\Requests\Api\V1\Disputes;

use App\Enums\Api\V1\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class DeleteDisputeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user?->hasPermissionTo(Permissions::DELETE_DISPUTES) && $this->dispute->user_id === $user->id;
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
