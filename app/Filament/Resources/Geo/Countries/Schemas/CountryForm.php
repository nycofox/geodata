<?php

namespace App\Filament\Resources\Geo\Countries\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('version')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('cca2')
                    ->required(),
                TextInput::make('cca3')
                    ->required(),
                TextInput::make('cioc'),
                TextInput::make('name_common')
                    ->required(),
                TextInput::make('name_official')
                    ->required(),
                Textarea::make('translations')
                    ->columnSpanFull(),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
                Textarea::make('bbox')
                    ->columnSpanFull(),
                TextInput::make('area_km2')
                    ->numeric(),
                Textarea::make('borders')
                    ->columnSpanFull(),
                TextInput::make('region'),
                TextInput::make('subregion'),
                TextInput::make('population')
                    ->numeric(),
                Textarea::make('currencies')
                    ->columnSpanFull(),
                Textarea::make('languages')
                    ->columnSpanFull(),
                Textarea::make('demonyms')
                    ->columnSpanFull(),
                Textarea::make('calling_codes')
                    ->columnSpanFull(),
                Textarea::make('timezones')
                    ->columnSpanFull(),
                TextInput::make('flag_emoji'),
                TextInput::make('flag_svg_url'),
                TextInput::make('geonames_id'),
                DateTimePicker::make('geonames_updated_at'),
                DateTimePicker::make('rest_countries_updated_at'),
                TextInput::make('capital_city_id')
                    ->numeric(),
            ]);
    }
}
