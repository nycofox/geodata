<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\Geo\CityFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'created_at'
    ];

    protected function casts(): array
    {
        return [
            'population' => 'integer',
            'area' => 'float',
            'translations' => 'array',
            'geonames_updated_at' => 'datetime',
            'openstreetmap_updated_at' => 'datetime',
            'wikidata_updated_at' => 'datetime',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
