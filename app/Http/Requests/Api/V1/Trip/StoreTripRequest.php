<?php

namespace App\Http\Requests\Api\V1\Trip;

use App\Enums\Api\V1\Permissions;
use App\Enums\Api\V1\TripStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasPermissionTo(Permissions::CREATE_TRIP);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'driver_id' => ['required', 'exists:users,id'],
        ];
    }

    public function passedValidation(): void
    {
        $this->merge([
            'status' => TripStatus::PENDING,
        ]);
    }
}
