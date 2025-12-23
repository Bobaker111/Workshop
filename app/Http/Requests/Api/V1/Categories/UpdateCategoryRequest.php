<?php

namespace App\Http\Requests\Api\V1\Categories;

use App\Enums\Api\V1\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasPermissionTo(Permissions::UPDATE_CATEGORY);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string', 'max:255'],
            'icon_class' => ['sometimes', 'nullable', 'string', 'max:255'],
            'category_id' => ['sometimes', 'exists:categories,id'],
        ];
    }
}
