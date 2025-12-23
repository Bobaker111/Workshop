<?php

namespace App\Http\Requests\Api\V1\Uploads;

use App\Enums\Api\V1\Permissions;
use App\Enums\Api\V1\UploadCapableType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AuthorizeUploadOperationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermissionTo(Permissions::UPLOAD_FILES);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'entity_id' => ['required', 'integer'],
            'entity_type' => ['required', 'string', new Enum(UploadCapableType::class)],
        ];
    }
}
