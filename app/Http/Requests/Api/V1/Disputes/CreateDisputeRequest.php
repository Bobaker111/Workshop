<?php

namespace App\Http\Requests\Api\V1\Disputes;

use App\Enums\Api\V1\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class CreateDisputeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasPermissionTo(Permissions::CREATE_DISPUTES);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'body' => ['required', 'string', 'max:10000'],
            'is_resolved' => ['sometimes', 'boolean'],
        ];
    }
}
