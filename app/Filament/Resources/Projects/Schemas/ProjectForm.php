<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Basic Info')
                ->schema([

                    TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            fn ($state, callable $set) =>
                                $set('slug', Str::slug($state))
                        ),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Select::make('category')
                        ->options([
                            'LMS' => 'LMS / Education',
                            'E-commerce' => 'E-commerce',
                            'Sports' => 'Sports',
                            'Fitness' => 'Fitness / Health',
                            'Fintech' => 'Fintech',
                            'Other' => 'Other',
                        ]),

                    Textarea::make('short_description')
                        ->required()
                        ->rows(2)
                        ->columnSpanFull(),

                    RichEditor::make('full_description')
                        ->columnSpanFull(),

                ])
                ->columns(2),

            Section::make('Case study')
                ->description('Optional. Shown at the top of the project popup. Each box is hidden while empty. Plain text; a blank line starts a new paragraph.')
                ->collapsible()
                ->schema([

                    TextInput::make('my_role')
                        ->label('My role')
                        ->placeholder('e.g. Backend developer in a team of 4')
                        ->columnSpanFull(),

                    Textarea::make('challenge')
                        ->label('The problem')
                        ->helperText('What was hard or missing? Who was it for?')
                        ->rows(3)
                        ->autosize()
                        ->columnSpanFull(),

                    Textarea::make('solution')
                        ->label('What I built')
                        ->helperText('The decisions you made and why, not just the tech list.')
                        ->rows(3)
                        ->autosize()
                        ->columnSpanFull(),

                    Textarea::make('outcome')
                        ->label('The result')
                        ->helperText('Real numbers or outcomes only (users, speed, time saved, launch). Leave empty if you have none.')
                        ->rows(3)
                        ->autosize()
                        ->columnSpanFull(),

                ]),

            Section::make('Media')
                ->schema([

                    FileUpload::make('thumbnail')
                        ->image()
                        ->directory('projects/thumbnails')
                        ->columnSpanFull(),

                    TextInput::make('demo_video_url')
                        ->label('Demo Video URL (YouTube / Vimeo)')
                        ->url()
                        ->columnSpanFull(),

                ]),

            Section::make('Links & Tags')
                ->schema([

                    TextInput::make('github_url')
                        ->label('GitHub URL')
                        ->url(),

                    TextInput::make('live_url')
                        ->label('Live URL')
                        ->url(),

                    TagsInput::make('tech_tags')
                        ->placeholder('Add a tech tag...')
                        ->columnSpanFull(),

                ])
                ->columns(2),

            Section::make('Settings')
                ->schema([

                    Toggle::make('is_featured')
                        ->label('Featured'),

                    Toggle::make('is_published')
                        ->label('Published')
                        ->default(true),

                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),

                ])
                ->columns(3),

        ]);
    }
}