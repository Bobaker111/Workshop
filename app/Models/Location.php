<?php

namespace App\Models;

use App\Casts\Geography\Point;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int|string $id
 * @property-read User $user
 * @property ?Point $location
 * @property-read string $created_at
 * @property-read string $updated_at
 */
class Location extends Model
{
    protected function casts(): array
    {
        return [
            'location' => Point::class,
        ];
    }

    /**
     * @return BelongsTo<User, Location>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
