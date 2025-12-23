<?php

namespace App\Http\Requests\Api\V1\Chat;

use APp\Enums\Api\V1\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class ListMessagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user->hasPermissionTo(Permissions::EXCHANGE_MESSAGES) && $user->hasAccessToConversation($this->conversation_id);
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
