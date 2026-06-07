<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable(),

                TextColumn::make('subject')
                    ->limit(40),

                IconColumn::make('is_read')
                    ->boolean()
                    ->label('Read'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Received'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),

                Action::make('mark_read')
                    ->label('Mark read')
                    ->icon('heroicon-o-check')
                    ->action(fn ($record) => $record->update([
                        'is_read' => true,
                        'read_at' => now(),
                    ]))
                    ->visible(fn ($record) => ! $record->is_read),
            ]);
    }
}