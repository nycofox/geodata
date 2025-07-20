<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\Geo\CountryFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'geonames_updated_at',
        'rest_countries_updated_at',
    ];

    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class);
    }

    protected static function booted(): void
    {
        static::updating(function (Country $country) {
            // Get only the attributes whose new value differs from the original
            $dirty = $country->getDirty();

            // Remove both the auto‑touched updated_at and your custom timestamp
            $ignored = [
                $country->getUpdatedAtColumn(),
                'geonames_updated_at',
                'rest_countries_updated_at',
            ];
            $dirty = Arr::except($dirty, $ignored);

            // If anything else is in there, bump the version
            if (count($dirty) > 0) {
                $country->version++;
            }
        });
    }
}
