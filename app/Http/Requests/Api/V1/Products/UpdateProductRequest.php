<?php

namespace App\Http\Requests\Api\V1\Products;

use App\Enums\Api\V1\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $this->product->store_id === $user->id && $user?->hasPermissionTo(Permissions::UPDATE_PRODUCT);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['sometimes', 'exists:categories,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string', 'max:255'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'weight' => ['sometimes', 'numeric', 'min:0'],
            'height' => ['sometimes', 'numeric', 'min:0'],
            'width' => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
