<?php

namespace Database\Factories\Geo;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Geo\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cca2' => strtoupper($this->faker->unique()->lexify('??')),
            'cca3' => strtoupper($this->faker->unique()->lexify('???')),
            'cioc' => strtoupper($this->faker->lexify('???')),
            'name_common' => $this->faker->unique()->country(),
            'name_official' => $this->faker->unique()->sentence(3),
            'translations' => json_encode([]),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'bbox' => json_encode([]),
            'area_km2' => $this->faker->randomFloat(2, 1000, 10000000),
            'borders' => json_encode([]),
            'region' => $this->faker->randomElement(['Africa', 'Americas', 'Asia', 'Europe', 'Oceania']),
            'subregion' => $this->faker->randomElement([
                'Northern Africa',
                'Eastern Africa',
                'Western Africa',
                'Southern Africa',
                'Northern America',
                'South America',
                'Central America',
                'Caribbean',
                'Eastern Asia',
                'Southern Asia',
                'South-Eastern Asia',
                'Western Asia',
                'Central Asia',
                'Northern Europe',
                'Southern Europe',
                'Eastern Europe',
                'Western Europe',
                'Australia and New Zealand',
                'Melanesia',
                'Micronesia',
                'Polynesia',
            ]),
            'population' => $this->faker->numberBetween(100000, 1000000000),
            'currencies' => json_encode([]),
            'languages' => json_encode([]),
            'demonyms' => json_encode([]),
            'calling_codes' => json_encode([]),
            'timezones' => json_encode([]),
            'flag_emoji' => '🏴',
            'flag_svg_url' => $this->faker->imageUrl(),
            'geonames_id' => (string) $this->faker->numberBetween(1000000, 9999999),
            'version' => 1,
        ];
    }
}
