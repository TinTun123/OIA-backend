<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryResource\Pages;
use App\Filament\Resources\StoryResource\RelationManagers;
use App\Models\Story;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoryResource extends Resource
{
    protected static ?string $model = Story::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //

                Forms\Components\Section::make('Basic Info')
                    ->schema([
                        TextInput::make('title')->required(),
                        TextInput::make('title_bur')->required(),
                        Textarea::make('description')->label("Quote"),
                        Textarea::make('description_bur')->label("Quote Burmese"),
                        FileUpload::make('cover_url')->label("Cover image")
                            ->image()
                            ->directory('stories/covers'),
                    ]),

                Forms\Components\Section::make('Content Blocks')
                    ->schema([
                        Repeater::make('blocks')
                            ->relationship('blocks')  // story -> story_blocks
                            ->orderColumn('order')    // auto ordering
                            ->defaultItems(0)
                            ->collapsible()
                            ->schema([

                                // Block type selector
                                Select::make('type')
                                    ->options([
                                        'text' => 'Rich Text Block',
                                        'image_quote' => 'Image + Quote Block',
                                    ])
                                    ->required()
                                    ->reactive(),


                                // ✅ Richtext block
                                RichEditor::make('text')
                                    ->label('Content English')
                                    ->visible(fn($get) => $get('type') === 'text')
                                    ->columnSpanFull(),

                                RichEditor::make('text_bur')
                                    ->label('Content Burmese')
                                    ->visible(fn($get) => $get('type') === 'text')
                                    ->columnSpanFull(),

                                // ✅ Quote + Image block
                                Textarea::make('text')
                                    ->label('Quote Text')
                                    ->visible(fn($get) => $get('type') === 'image_quote')
                                    ->columnSpanFull(),

                                Textarea::make('text_bur')
                                    ->label('Quote Text Burmese')
                                    ->visible(fn($get) => $get('type') === 'image_quote')
                                    ->columnSpanFull(),

                                FileUpload::make('image_url')
                                    ->label('Image')
                                    ->directory('stories/content-blocks')
                                    ->image()
                                    ->visible(fn($get) => $get('type') === 'image_quote'),
                            ])
                            ->addActionLabel('Add Content Block'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('title'),
                TextColumn::make('description')->limit(30)->searchable(),
                ImageColumn::make('cover_url')->square(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListStories::route('/'),
            'create' => Pages\CreateStory::route('/create'),
            'edit' => Pages\EditStory::route('/{record}/edit'),
        ];
    }
}
