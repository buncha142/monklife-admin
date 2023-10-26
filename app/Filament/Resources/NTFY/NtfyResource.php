<?php

namespace App\Filament\Resources\NTFY;

use App\Filament\Resources\NTFY\NtfyResource\Pages;
use App\Filament\Resources\NTFY\NtfyResource\RelationManagers;
use App\Models\NTFY\Ntfy;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class NtfyResource extends Resource
{
    protected static ?string $model = Ntfy::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';

    protected static ?string $navigationGroup = 'แจ้งเตือน';

    protected static ?string $navigationLabel = 'รายการ';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('ข้อมูลแจ้งเตือน')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('หัวข้อ')
                                    ->columnSpanFull()
                                    ->required(),
                                Forms\Components\Textarea::make('body')
                                    ->label('เพิ่มเติม(ถ้ามี)')
                                    ->columnSpanFull()
                                    ->rows(4),
                                Forms\Components\Select::make('passenger')
                                    ->label('ผู้รับบุญ(ถ้ามี)')
                                    ->multiple()
                                    ->options(User::actived()->orderBy('doo', 'asc')->pluck('nickname', 'nickname'))
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\Select::make('user_id')
                                    ->label('ผู้ทำรายการ')
                                    ->options(User::actived()->orderBy('doo', 'asc')->pluck('nickname', 'id'))
                                    ->default(Auth::id())
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->directory('ntfy-image')
                                    ->label('ภาพ(ถ้ามี)')
                                    ->columnSpanFull(),

                            ]),
                    ]),
                Forms\Components\Fieldset::make('กำหนดการแจ้งเตือน')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('วันเวลาแจ้งเตือน')
                                    ->columnSpan('full')
                                    ->native(true)
                                    ->hoursStep(1)
                                    ->minutesStep(1)
                                    ->required(),

                                    Forms\Components\Toggle::make('is_active')
                                    ->label('แจ้งเตือน')
                                    ->default('true')
                                    ->onIcon('heroicon-o-bell-alert')
                                    ->offIcon('heroicon-o-bell-slash'),

                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('ภารกิจ')->searchable(),
                Tables\Columns\TextColumn::make('body')->label('เพิ่มเติม')->limit(15)->searchable(),
                Tables\Columns\ImageColumn::make('image')->label('ภาพ')->stacked()->limit(3)->limitedRemainingText(),
                Tables\Columns\TextColumn::make('published_at')->label('วันเวลาแจ้งเตือน')->formatStateUsing(fn (string $state): string => thaidate('l j M y H:i น.',"{$state}"))->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')->label('แจ้งเตือน')->onIcon('heroicon-o-bell-alert')->offIcon('heroicon-o-bell-slash'),
                Tables\Columns\TextColumn::make('passenger')->label('ผู้รับบุญ')->badge()->separator(','),
                Tables\Columns\TextColumn::make('user.nickname')->label('ผู้ทำรายการ')->badge(),
            ])->defaultSort('published_at' ,'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groups([
            Tables\Grouping\Group::make('published_at')->label('วันแจ้งเตือน')
                    ->date(),
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
            'index' => Pages\ListNtfies::route('/'),
            'create' => Pages\CreateNtfy::route('/create'),
            'edit' => Pages\EditNtfy::route('/{record}/edit'),
        ];
    }
}
