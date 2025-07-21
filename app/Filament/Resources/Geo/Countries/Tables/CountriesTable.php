<?php

namespace App\Filament\Resources\Geo\Countries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CountriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_common')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('version')
                    ->numeric()
                    ->sortable(),
//                TextColumn::make('cca2')
//                    ->searchable(),
                TextColumn::make('cca3')
                    ->searchable(),
//                TextColumn::make('cioc')
//                    ->searchable(),

                TextColumn::make('name_official')
                    ->searchable(),
//                TextColumn::make('latitude')
//                    ->numeric()
//                    ->sortable(),
//                TextColumn::make('longitude')
//                    ->numeric()
//                    ->sortable(),
//                TextColumn::make('area_km2')
//                    ->numeric()
//                    ->sortable(),
                TextColumn::make('region')
                    ->searchable(),
                TextColumn::make('subregion')
                    ->searchable(),
                TextColumn::make('population')
                    ->numeric()
                    ->sortable(),
//                TextColumn::make('flag_emoji')
//                    ->searchable(),
//                TextColumn::make('flag_svg_url')
//                    ->searchable(),
//                TextColumn::make('geonames_id')
//                    ->searchable(),
                TextColumn::make('geonames_updated_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('rest_countries_updated_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
//                TextColumn::make('updated_at')
//                    ->dateTime()
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                TextColumn::make('capital_city_id')
//                    ->numeric()
//                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
