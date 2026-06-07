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
                    ->options([
                        'Backend' => 'Backend',
                        'Frontend' => 'Frontend',
                        'Database' => 'Database',
                        'DevOps' => 'DevOps',
                        'Tools' => 'Tools & AI',
                    ])
                    ->required(),

                TextInput::make('icon')
                    ->placeholder('brand-laravel')
                    ->helperText('Heroicon name (without heroicon-o- prefix)'),

                TextInput::make('proficiency')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(80)
                    ->suffix('%'),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_visible')
                    ->default(true),
            ])
            ->columns(2);
    }
}