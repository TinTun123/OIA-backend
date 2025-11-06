<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarousalResource\Pages;
use App\Filament\Resources\CarousalResource\RelationManagers;
use App\Models\Carousal;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarousalResource extends Resource
{
    protected static ?string $model = Carousal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('page')
                    ->label('Page Name')
                    ->required(),

                Repeater::make('slides')
                    ->relationship('slides')
                    ->label('Carousal Slides')
                    ->orderColumn('sort_order')
                    ->schema([
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpan(12),
                        Textarea::make('description_bur')
                            ->rows(3)
                            ->columnSpan(12),

                        FileUpload::make('image_url')
                            ->label('Slide Image')
                            ->image()
                            ->directory('carousals/slides')
                            ->columnSpan(12),
                    ])
                    ->columns(12)
                    ->minItems(1)
                    ->collapsible()
                    ->defaultItems(1)
                    ->addActionLabel('Add Slide'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('page')->searchable()->sortable(),
                TextColumn::make('slides_count')
                    ->counts('slides')
                    ->label('Slides')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCarousals::route('/'),
            'create' => Pages\CreateCarousal::route('/create'),
            'edit' => Pages\EditCarousal::route('/{record}/edit'),
        ];
    }
}
