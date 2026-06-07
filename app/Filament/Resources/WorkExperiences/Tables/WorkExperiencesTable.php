<?php

namespace App\Filament\Resources\WorkExperiences\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('role')
                    ->searchable(),

                TextColumn::make('company')
                    ->searchable(),

                TextColumn::make('period'),

                IconColumn::make('is_current')
                    ->boolean()
                    ->label('Current'),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make(),
            ]);
    }
}

//Two things may require adjustment depending on your exact Filament 5.6 installation:

// Repeater namespace/API — if Filament reports Repeater issues, paste the generated form schema skeleton and I'll adapt it.
// Table reordering (->reorderable('sort_order')) was intentionally omitted until we confirm the exact Filament 5.6 API available in your generated table classes