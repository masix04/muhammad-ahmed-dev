<?php

namespace App\Filament\Resources\Skills\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                Select::make('category')
                    // Driven by config so the admin can never drift from the badge colours.
                    // 'All' is the front-end filter pseudo-category, not a real one.
                    ->options(fn () => collect(config('skill-categories.categories'))
                        ->keys()
                        ->reject(fn (string $category) => $category === 'All')
                        ->mapWithKeys(fn (string $category) => [$category => $category])
                        ->all())
                    ->required(),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_visible')
                    ->default(true),
            ])
            ->columns(2);
    }
}