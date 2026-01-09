<?php

namespace App\Filament\Resources\Geo\Cities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('version')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('country.id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('name_native')
                    ->searchable(),
                TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('population')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('elevation_m')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('admin1')
                    ->searchable(),
                TextColumn::make('admin2')
                    ->searchable(),
                TextColumn::make('admin3')
                    ->searchable(),
                TextColumn::make('geonames_id')
                    ->searchable(),
                TextColumn::make('geonames_updated_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('wikidata_id')
                    ->searchable(),
                TextColumn::make('wikipedia_url')
                    ->searchable(),
                TextColumn::make('openstreetmap_place_id')
                    ->searchable(),
                TextColumn::make('openstreetmap_updated_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('timezone')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
