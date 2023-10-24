<?php

namespace App\Filament\Resources\CRS;

use App\Filament\Resources\CRS\ListResource\Pages;
use App\Filament\Resources\CRS\ListResource\RelationManagers;
use App\Models\CRS\Driver;
use App\Models\CRS\Lists;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ListResource extends Resource
{
    protected static ?string $model = Lists::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'จองรถ';

    protected static ?string $navigationLabel = 'รายการ';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('ข้อมูลเดินทาง')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('name')
                                    ->label('ภารกิจ')
                                    ->required(),

                                Forms\Components\Select::make('car_id')
                                    ->label('เลือกรถ')
                                    ->relationship(
                                        name: 'car',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn (Builder $query) => $query->actived(),
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\Select::make('driver_id')
                                    ->label('สารถี')
                                    ->relationship(
                                        name: 'driver',
                                    )
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->user->nickname}")
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\Select::make('user_id')
                                    ->label('ผู้จอง')
                                    ->relationship(
                                        name: 'user',
                                        titleAttribute: 'nickname',
                                        modifyQueryUsing: fn (Builder $query) => $query->actived()->orderBy('doo', 'asc')
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\Select::make('passenger')
                                    ->label('ผู้โดยสาร')
                                    ->multiple()
                                    ->options(User::actived()->orderBy('doo', 'asc')->pluck('nickname', 'nickname'))
                                    ->searchable()
                                    ->preload()
                                    ->columnSpanFull(),

                                    Forms\Components\Textarea::make('description')
                                    ->label('รายละเอียดเพิ่มเติม')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                    ]),
                Forms\Components\Fieldset::make('วัน-เวลาเดินทาง')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->label('วันเดินทาง')
                                    ->after('yesterday')
                                    ->required(),

                                Forms\Components\DatePicker::make('end_date')
                                    ->label('วันกลับ (กรณีค้างคืน)')
                                    ->after('start_date'),
                                Forms\Components\TimePicker::make('start_time')
                                    ->label('เวลาเดินทาง')
                                    ->seconds(false)
                                    ->required(),
                                Forms\Components\TimePicker::make('end_time')
                                    ->label('เวลากลับ')
                                    ->seconds(false)
                                    ->required(),

                                Forms\Components\Toggle::make('travel')
                                    ->label('เดินทางไปกลับ')
                                    ->default(0),

                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('ภารกิจ')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('car.name')->label('รถ'),
                Tables\Columns\TextColumn::make('driver.user.nickname')->label('คนขับ'),
                Tables\Columns\TextColumn::make('user.nickname')->label('จอง'),
                Tables\Columns\TextColumn::make('start_date')->label('วันเดินทาง')
                ->toggleable()->formatStateUsing(fn (string $state): string => thaidate('D j M y',"{$state}")),
                Tables\Columns\TextColumn::make('start_time')->label('เวลา')->toggleable()->formatStateUsing(fn (string $state): string => thaidate('H:m',"{$state}").' น.'),
                Tables\Columns\TextColumn::make('end_date')->label('วันกลับ')->toggleable()->formatStateUsing(fn (string $state): string => thaidate('D j M y',"{$state}")),
                Tables\Columns\TextColumn::make('end_time')->label('เวลากลับ')->toggleable()->formatStateUsing(fn (string $state): string => thaidate('H:m',"{$state}").' น.'),
                Tables\Columns\TextColumn::make('passenger')->label('ผู้เดินทาง')->toggleable()
                ->formatStateUsing(fn (string $state): string => __("{$state}"))->separator(','),
                Tables\Columns\TextColumn::make('description')->label('เพิ่มเติม')->toggleable()->searchable(),
            ])->defaultSort('start_date' ,'desc')
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
            'index' => Pages\ListLists::route('/'),
            'create' => Pages\CreateList::route('/create'),
            'edit' => Pages\EditList::route('/{record}/edit'),
        ];
    }
}
