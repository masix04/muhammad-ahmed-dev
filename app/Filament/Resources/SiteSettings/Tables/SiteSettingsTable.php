<?php

namespace App\Filament\Resources\SiteSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->searchable(),

                TextColumn::make('value')
                    ->limit(60)
                    ->placeholder('— empty (hidden) —'),

                TextColumn::make('type')
                    ->badge(),
            ])
            ->defaultSort('key')
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
