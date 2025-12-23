<?php

namespace App\Http\Requests\Api\V1\Products;

use App\Enums\Api\V1\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class DeleteProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $this->product->store_id === $user->id && $user?->hasPermissionTo(Permissions::DELETE_PRODUCT);
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
