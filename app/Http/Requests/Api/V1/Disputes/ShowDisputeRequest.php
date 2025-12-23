<?php

namespace App\Http\Requests\Api\V1\Disputes;

use App\Enums\Api\V1\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class ShowDisputeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasPermissionTo(Permissions::SHOW_DISPUTE);
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
