<?php

namespace App\Filament\Resources;

use App\Filament\Plugins\ImageResizePlugin;
use App\Filament\Resources\ServiceFormResource\Pages;
use App\Filament\Resources\ServiceFormResource\RelationManagers;
use App\Models\ServiceForm;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceFormResource extends Resource
{
    protected static ?string $model = ServiceForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('service_id')
                    ->label('Choose Service')
                    ->relationship('service', 'title')   // THIS auto-loads services
                    ->searchable()
                    ->required()
                    ->preload(),
                Section::make('Form Information')
                    ->schema([
                        RichEditor::make('form_data')->required()
                        // ->plugins([
                        //     ImageResizePlugin::make(),
                        // ])
                        ,
                    ]),

                Section::make('Form Information burmese')
                    ->schema([
                        RichEditor::make('form_data_bur')->nullable()
                        // ->plugins([
                        //     ImageResizePlugin::make(),
                        // ])
                        ,
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('service.title')->label('Service'),
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
            'index' => Pages\ListServiceForms::route('/'),
            'create' => Pages\CreateServiceForm::route('/create'),
            'edit' => Pages\EditServiceForm::route('/{record}/edit'),
        ];
    }
}
