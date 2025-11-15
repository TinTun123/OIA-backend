<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        Textarea::make('title')
                            ->label('Title (English)')
                            ->required(),

                        Textarea::make('title_bur')
                            ->label('Title (Burmese)'),

                        DatePicker::make('date')
                            ->label('Date')
                            ->required(),

                        TagsInput::make('tags')
                            ->label('Tags'),
                        Select::make('type')
                            ->label('Program')
                            ->options([
                                'Food Security' => 'Food Security',
                                'Emergency Response' => 'Emergency Response',
                                'Training' => 'Training',
                                'Health & Education' => 'Health & Education',
                                'Advocacy' => 'Advocacy',
                                'Organizational Development' => 'Organizational Development',
                                'Protection (HRDs, GBV & Child Protection)' => 'Protection (HRDs, GBV & Child Protection)',
                            ])
                            ->searchable()
                            ->required(),
                        Select::make('fb_template')
                            ->label('FB Post Template')
                            ->options([
                                'image_text' => 'Image & Text',
                                'website_link' => 'Website Link',
                                'gallery' => 'Gallery Post',
                            ])
                            ->reactive(),
                        // TextInput::make('fbURL')
                        //     ->label('Facebook Post URL')
                        //     ->url()
                        //     ->nullable()
                    ])
                    ->columns(2),
                Section::make("Cover image")->schema([
                    FileUpload::make('cover_url')
                        ->label('Cover Image')
                        ->image()
                        ->directory('posts/covers')
                        ->dehydrated(fn($state) => filled($state))
                        ->saveUploadedFileUsing(function ($file) {
                            if ($file) {
                                return $file->store('posts/covers', 'public');
                            }
                            return null;
                        })->default(fn($record) => $record?->cover_url),
                ]),


                Section::make('Content')
                    ->schema([
                        Textarea::make('content')
                            ->label('Content (English)')
                            ->columnSpanFull(),
                        Textarea::make('content_bur')
                            ->label('Content (Burmese)')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Gallery Images')
                    ->schema([
                        FileUpload::make('images')
                            ->label('Additional Images')
                            ->multiple()
                            ->image()
                            ->directory('posts/images')
                            ->reorderable()
                            ->appendFiles()
                            ->downloadable()
                            ->openable()
                            ->default(function ($record) {
                                return $record?->images ?? [];
                            })
                            ->dehydrated(fn($state) => filled($state))

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->limit(30)->searchable(),
                TextColumn::make('type'),
                TextColumn::make('date')->date(),
                ImageColumn::make('cover_url')->square(),
                TextColumn::make('tags'),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
