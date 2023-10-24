<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\PermissionResource\RelationManagers;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $slug = 'setting/permission';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'ตั้งค่า';

    protected static ?string $navigationLabel = 'โปรแกรม';

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('โปรแกรม')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('ชื่อ โปรแกรม')
                        ->required()
                        ->unique()
                        ->minLength(2)
                        ->maxLength(255)
                        ->columnSpan('full'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name')->label('โปรแกรม'),
                Tables\Columns\TextColumn::make('created_at')->since(),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}
