<?php

namespace App\Http\Requests\Api\V1\Trip;

use App\Enums\Api\V1\Permissions;
use App\Enums\Api\V1\TripStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user?->hasPermissionTo(Permissions::UPDATE_TRIP) && $this->trip->driver_id === $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(TripStatus::class)],
        ];
    }
}
