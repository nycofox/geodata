<?php

namespace App\Filament\Resources\Geo\Cities\Pages;

use App\Filament\Resources\Geo\Cities\CityResource;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\CreateRecord;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;

    protected function getFormSchema(): array
    {
        return [
            Select::make('place_id')
                ->label('Search for a city')
                ->required()
                ->searchable()
                // As the user types, hit your NominatimService
                ->getSearchResultsUsing(fn(string $query) => app(NominatimService::class)
                    ->searchCities($query)
                    // map to [place_id => display_name]
                    ->mapWithKeys(fn(array $r) => [
                        $r['place_id'] => ($r['namedetails']['name:en'] ?? $r['name'])
                            .', '. data_get($r, 'address.country'),
                    ])
                    ->toArray()
                ),
        ];
    }

    /**
     * Intercept Filament's normal record-creation and
     * instead call your UpsertCity action.
     */
    protected function handleRecordCreation(array $data): \App\Models\Geo\City
    {
        // 1) fetch the full payload from OSM
        $apiResult = app(NominatimService::class)
            ->getPlaceDetails($data['place_id']);

        if (! $apiResult) {
            $this->notify('danger', 'Could not retrieve city details.');
            abort(404);
        }

        // 2) upsert via your action
//        return app(UpsertCity::class)->execute($apiResult);
    }

    /**
     * We don’t actually have a `place_id` column on City,
     * so strip it out before Filament tries to mass‑assign.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['place_id']);
        return $data;
    }
}
