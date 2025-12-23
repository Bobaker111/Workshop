<?php

namespace App\Models;

use App\Enums\Api\V1\TripStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|string $id
 * @property int|string $driver_id
 * @property TripStatus $status
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Trip extends Model
{
    protected function casts(): array
    {
        return [
            'status' => TripStatus::class,
        ];
    }

    /**
     * @return BelongsTo<User, Trip>
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function getTrackingInformation(): array
    {
        return [
            'message' => 'getting tracking info for trip '.$this->id,
        ];
    }
}
