<?php

namespace App\Http\Requests\Api\V1\Uploads;

use App\Enums\Api\V1\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasPermissionTo(Permissions::UPLOAD_FILES);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'files' => ['required'],
            'files.*' => ['required', 'file', 'mimes:jpg,jpeg,png,mp3,mp4,mkv,wav', 'max:1024000'], // 100MB
        ];
    }
}
