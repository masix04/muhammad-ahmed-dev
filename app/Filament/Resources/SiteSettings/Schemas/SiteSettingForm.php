<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->disabled()
                    ->helperText('Read by name in the views — renaming would silently break them.'),

                TextInput::make('type')
                    ->disabled()
                    ->helperText('Decides which input is shown below.'),

                Toggle::make('value')
                    ->label('Enabled')
                    ->visible(fn (Get $get) => $get('type') === 'boolean')
                    ->dehydrateStateUsing(fn ($state) => $state ? '1' : '0')
                    ->columnSpanFull(),

                Textarea::make('value')
                    ->label('Value')
                    ->rows(3)
                    ->autosize()
                    ->visible(fn (Get $get) => $get('type') !== 'boolean')
                    ->helperText('Leave empty to hide the element that uses it.')
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
