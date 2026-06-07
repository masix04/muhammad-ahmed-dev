<?php

namespace App\Filament\Resources\WorkExperiences\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Position')
                ->schema([
                    TextInput::make('role')
                        ->required(),

                    TextInput::make('company')
                        ->required(),

                    TextInput::make('location'),

                    TextInput::make('period')
                        ->placeholder('Jun 2024 – Dec 2025')
                        ->required(),

                    DatePicker::make('start_date')
                        ->required(),

                    DatePicker::make('end_date'),

                    Toggle::make('is_current')
                        ->label('Currently working here')
                        ->columnSpanFull(),

                    TextInput::make('company_url')
                        ->url()
                        ->label('Company URL'),

                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),
                ])
                ->columns(2),

            Section::make('Key responsibilities')
                ->schema([
                    Repeater::make('bullets')
                        ->schema([
                            TextInput::make('bullet')
                                ->placeholder('What did you build or achieve?')
                                ->required(),
                        ])
                        ->addActionLabel('Add bullet point')
                        ->columnSpanFull(),
                ]),

            Section::make('Sub-projects')
                ->schema([
                    Repeater::make('sub_projects')
                        ->schema([
                            TextInput::make('name')
                                ->required(),

                            Textarea::make('desc')
                                ->rows(2),

                            TagsInput::make('tags')
                                ->placeholder('Add tech tag'),
                        ])
                        ->columns(1)
                        ->addActionLabel('Add sub-project')
                        ->columnSpanFull(),
                ]),

        ]);
    }
}