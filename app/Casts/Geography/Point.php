<?php

namespace App\Casts\Geography;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Point implements CastsAttributes
{

    public float $longitude;
    public float $latitude;

    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?array
    {
        if ($value === null) {
            return null;
        }

        $coordinates = unpack('x4/corder/Ltype/dlng/dlat', $value);


        return ['longitude' => $coordinates['lng'], 'latitude' => $coordinates['lat']];
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return DB::raw(sprintf('ST_SRID( Point(%s, %s), 4326 )', $value['longitude'], $value['latitude']));
    }
}
