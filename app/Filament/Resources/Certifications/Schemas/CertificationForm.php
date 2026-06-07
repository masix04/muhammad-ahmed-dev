<?php

namespace App\Filament\Resources\Certifications\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CertificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('issuer')
                    ->required(),

                TextInput::make('issued_date')
                    ->placeholder('Mar 2023'),

                TextInput::make('verification_url')
                    ->url()
                    ->label('Verification URL'),

                FileUpload::make('certificate_image')
                    ->image()
                    ->directory('certifications')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_visible')
                    ->default(true),
            ])
            ->columns(2);
    }
}