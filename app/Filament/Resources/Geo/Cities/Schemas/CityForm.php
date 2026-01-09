<?php

namespace App\Filament\Resources\Geo\Cities\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('version')
                    ->required()
                    ->numeric()
                    ->default(1),
                Select::make('country_id')
                    ->relationship('country', 'name_common')
                    ->label('Country')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('name_native'),
                Textarea::make('translations')
                    ->columnSpanFull(),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
                Textarea::make('bbox')
                    ->columnSpanFull(),
                TextInput::make('population')
                    ->numeric(),
                TextInput::make('elevation_m')
                    ->numeric(),
                TextInput::make('admin1'),
                TextInput::make('admin2'),
                TextInput::make('admin3'),
                TextInput::make('geonames_id'),
                TextInput::make('wikidata_id'),
                TextInput::make('wikipedia_url'),
                TextInput::make('openstreetmap_place_id'),
                TextInput::make('timezone'),
            ]);
    }
}
