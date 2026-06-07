<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->square(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->badge(),

                IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),

                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),

                TextColumn::make('sort_order')
                    ->sortable()
                    ->label('Order'),
            ])
            ->defaultSort('sort_order')
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Published'),

                TernaryFilter::make('is_featured')
                    ->label('Featured'),
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

//
// One thing to verify, Filament 5 changed several table APIs. If you get an error on:
// ->recordActions()
// or
// ->toolbarActions()
// paste the generated ProjectsTable.php that Filament created, and I'll align the methods with the exact API used by your installed version (5.6.6).
// */