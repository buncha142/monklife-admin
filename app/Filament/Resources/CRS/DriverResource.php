<?php

namespace App\Filament\Resources\CRS;

use App\Filament\Resources\CRS\DriverResource\Pages;
use App\Filament\Resources\CRS\DriverResource\RelationManagers;
use App\Models\CRS\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'จองรถ';

    protected static ?string $navigationLabel = 'สารถี';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\Fieldset::make('ข้อมูลสารถี')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\Select::make('user_id')
                                ->label('สารถี')
                                ->relationship(
                                    name: 'user',
                                    titleAttribute: 'nickname',
                                    modifyQueryUsing: fn (Builder $query) => $query->actived()->whereIn('status', ['อุบาสก', 'อุบาสิกา'])->doesntHave('drivers'),
                                    )
                                ->searchable()
                                ->preload()
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
                Tables\Columns\TextColumn::make('user.nickname')->label('สารถี'),
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
