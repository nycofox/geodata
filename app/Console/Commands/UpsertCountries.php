<?php

namespace App\Console\Commands;

use App\Models\Geo\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpsertCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:upsert-countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and update the list of countries and their data from a free API.';

    /**
     * The API endpoint.
     * REST Countries now requires specifying the fields to be returned.
     *
     * @var string
     */
    const RESTCOUNTRIES_ENDPOINT_BASE = 'https://restcountries.com/v3.1/all?fields=name,cca2,cca3,capital,area,region,subregion,population,latlng';
    const RESTCOUNTRIES_ENDPOINT_EXTRA = 'https://restcountries.com/v3.1/all?fields=cca3,timezones,demonyms,languages,currencies';
    const GEONAMES_ENDPOINT = 'http://api.geonames.org/countryInfoJSON?username=';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Fetching base country data...');

        $countries = $this->getCountryDataFromRestCountries();

        $this->info(count($countries) . ' countries found. Starting database update...');
        $progressBar = $this->output->createProgressBar(count($countries));
        $progressBar->start();

        foreach ($countries as $countryData) {
            $cca3 = $countryData['cca3'] ?? null;
            if (!$cca3) {
                $progressBar->advance();
                continue; // Skip if the record has no unique cca3 identifier
            }

            // Use updateOrCreate to efficiently add/update the database record
            $this->upsertCountryFromRestCountries($countryData);

            // Fetch additional data from Geonames
            $this->getCountryDataFromGeonames($cca3);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info("\nCountry database has been successfully updated.");

        return Command::SUCCESS;
    }

    private function getCountryDataFromRestCountries(): array
    {
        $response1 = Http::get(self::RESTCOUNTRIES_ENDPOINT_BASE);
        if ($response1->failed()) {
            $this->error('Failed to fetch country data from REST Countries API.');
            return [];
        }
        $response2 = Http::get(self::RESTCOUNTRIES_ENDPOINT_EXTRA);
        if ($response2->failed()) {
            $this->error('Failed to fetch extra country data from REST Countries API.');
            return [];
        }

        // Combine the two responses into a single array
        $countries = $response1->json();

        foreach ($countries as $country) {
            $cca3 = $country['cca3'] ?? null;
            if ($cca3) {
                $extraData = collect($response2->json())->firstWhere('cca3', $cca3);
                if ($extraData) {
                    // Merge extra data into the country array
                    $country = array_merge($country, [
                        'timezones' => $extraData['timezones'] ?? [],
                        'demonyms' => $extraData['demonyms'] ?? [],
                        'languages' => $extraData['languages'] ?? [],
                        'currencies' => $extraData['currencies'] ?? [],
                    ]);
                }
            }
        }

        return $countries;

    }

    private function upsertCountryFromRestCountries($countryData): void
    {
        Country::updateOrCreate(
            ['cca3' => $countryData['cca3']],
            [
                'name_common' => $countryData['name']['common'] ?? null,
                'name_official' => $countryData['name']['official'] ?? null,
                'cca2' => $countryData['cca2'] ?? null,
                'region' => $countryData['region'] ?? null,
                'subregion' => $countryData['subregion'] ?? null,
                'population' => $countryData['population'] ?? 0,
                'latitude' => $countryData['latlng'][0] ?? null,
                'longitude' => $countryData['latlng'][1] ?? null,
                'area_km2' => $countryData['area'] ?? null,
                'timezones' => json_encode($countryData['timezones'] ?? []),
                'demonyms' => json_encode($countryData['demonyms'] ?? []),
                'languages' => json_encode($countryData['languages'] ?? []),
                'currencies' => json_encode($countryData['currencies'] ?? []),
                'rest_countries_updated_at' => now(),
            ]
        );
    }

    private function getCountryDataFromGeonames(): array
    {
        $response = Http::get(self::GEONAMES_ENDPOINT . config('services.geonames.username'));
        if ($response->failed()) {
            $this->error('Failed to fetch country data from Geonames API.');
            return [];
        }

        $countries = $response->json()['geonames'] ?? [];

        foreach ($countries as $countryData) {
            $cca3 = $countryData['countryCode'] ?? null;
            if ($cca3) {
                Country::where('cca3', $cca3)->update([
                    'geonames_id' => $countryData['geonameId'] ?? null,
                    'geonames_updated_at' => now(),
                ]);
            }
        }

        return $countries;

    }
}
