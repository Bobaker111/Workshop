<?php

namespace App\Http\Requests\Api\V1\Chat;

use App\Enums\Api\V1\MessageType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'conversation_id' => ['required', 'exists:conversations,id'],
            'type' => ['required', new Enum(MessageType::class)],
            'body' => ['required', 'string'],
        ];
    }
}
