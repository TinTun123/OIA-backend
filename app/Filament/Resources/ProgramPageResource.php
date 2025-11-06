<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramPageResource\Pages;
use App\Filament\Resources\ProgramPageResource\RelationManagers;
use App\Models\ProgramPage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
// use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class ProgramPageResource extends Resource
{
    protected static ?string $model = ProgramPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('name_bur')->required(),
                        FileUpload::make('cover_url')
                            ->directory('programs')
                            ->image()
                            ->nullable()
                            ->label('Cover Image')
                            ->dehydrated(fn($state) => filled($state)) // only save if there is a value
                            ->saveUploadedFileUsing(function ($file) {
                                if ($file) {
                                    return $file->store('programs', 'public');
                                }
                                return null;
                            })->default(fn($record) => $record?->cover_url),
                        FileUpload::make('img_url')
                            ->directory('programs')
                            ->image()
                            ->nullable()
                            ->label('Secondary Image')->dehydrated(fn($state) => filled($state)) // only save if there is a value
                            ->saveUploadedFileUsing(function ($file) {
                                if ($file) {
                                    return $file->store('programs', 'public');
                                }
                                return null;
                            })->default(fn($record) => $record?->img_url),
                    ]),
                Section::make('Descriptions')
                    ->schema([
                        Textarea::make('description')->required(),
                        Textarea::make('description_bur')->required(),
                    ]),

                Section::make('Reason')
                    ->schema([
                        Textarea::make('reason')->required(),
                        Textarea::make('reason_bur')->required(),
                    ]),

                Section::make('Content Blocks')
                    ->schema([
                        RichEditor::make('content')->required(),
                        RichEditor::make('content_bur')->required(),
                    ]),

                Section::make('Quotes')
                    ->schema([
                        Textarea::make('quote')->required(),
                        Textarea::make('quote_bur')->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')->searchable(),
                ImageColumn::make('cover_url'),
                TextColumn::make('created_at')->dateTime(),
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
            'index' => Pages\ListProgramPages::route('/'),
            'create' => Pages\CreateProgramPage::route('/create'),
            'edit' => Pages\EditProgramPage::route('/{record}/edit'),
        ];
    }
}
