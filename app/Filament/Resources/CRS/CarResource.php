<?php

namespace App\Filament\Resources\CRS;

use App\Filament\Resources\CRS\CarResource\Pages;
use App\Filament\Resources\CRS\CarResource\RelationManagers;
use App\Models\CRS\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'จองรถ';

    protected static ?string $navigationLabel = 'รถ';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('ข้อมูลรถ')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('ชื่อรถ')
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('สถานะใช้งาน')
                                    ->default('true'),

                                Forms\Components\Toggle::make('is_default')
                                    ->label('ปักหมุด')
                                    ->default('true'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('ชื่อรถ'),
                Tables\Columns\ToggleColumn::make('is_active')->label('ใช้งาน')->sortable(),
                Tables\Columns\ToggleColumn::make('is_default')->label('ปัดหมุด')->sortable(),
            ])->defaultSort('is_active' ,'desc')->defaultSort('is_default' ,'desc')
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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
