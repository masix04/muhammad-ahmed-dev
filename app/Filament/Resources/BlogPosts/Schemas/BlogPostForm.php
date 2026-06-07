<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Schema;

use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            fn ($state, callable $set) => $set('slug', Str::slug($state))
                        )
                        ->columnSpanFull(),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    TextInput::make('read_time_minutes')
                        ->numeric()
                        ->default(3)
                        ->suffix('min'),

                    Textarea::make('excerpt')
                        ->rows(2)
                        ->columnSpanFull(),

                    RichEditor::make('body')
                        ->required()
                        ->columnSpanFull(),

                    TagsInput::make('tags')
                        ->columnSpanFull(),

                    FileUpload::make('cover_image')
                        ->image()
                        ->directory('blog')
                        ->columnSpanFull(),

                    Toggle::make('is_published'),

                    DateTimePicker::make('published_at'),
                ])
                ->columns(2),
        ]);
    }
}
