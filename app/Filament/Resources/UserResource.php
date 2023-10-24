<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'setting/users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'ตั้งค่า';

    protected static ?string $navigationLabel = 'ผู้ใช้งาน';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('ข้อมูลผู้ใช้')
                    ->schema([
                        Forms\Components\FileUpload::make('avatar')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                Null,
                                '1:1',
                            ])
                            ->columnSpan(2),


                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('สถานะ')
                                    ->options([
                                        'พระ' => 'พระ',
                                        'อุบาสก' => 'อุบาสก',
                                        'อุบาสิกา' => 'อุบาสิกา',
                                    ])
                                    ->required(),

                                Forms\Components\TextInput::make('name')
                                    ->label('ชื่อ')
                                    ->required(),

                                Forms\Components\TextInput::make('surname')
                                    ->label('นามสกุล/ฉายา')
                                    ->required(),

                                Forms\Components\TextInput::make('nickname')
                                    ->label('ชื่อเล่น')
                                    ->required(),


                            ]),

                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->label('เบอร์โทร'),

                                Forms\Components\TextInput::make('line_id')
                                    ->label('Line ID'),

                                Forms\Components\DatePicker::make('dob')
                                    ->label('วันเกิด (ปี ค.ศ.)')
                                    ->displayFormat('d/m/Y'),

                                Forms\Components\DatePicker::make('doo')
                                    ->label('วันบวช (ปี ค.ศ.)')
                                    ->displayFormat('d/m/Y'),
                            ]),

                    ]),

                Forms\Components\Fieldset::make('สิทธิการใช้งาน')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('roles')
                                    ->label('สิทธิ')
                                    ->relationship('roles', 'name')
                                    ->preload(),

                                Forms\Components\Select::make('permissions')
                                    ->label('โปรแกรม')
                                    ->multiple()
                                    ->relationship('permissions', 'name')
                                    ->preload(),

                            ]),

                    ]),

                Forms\Components\Fieldset::make('ข้อมูลสำหรับ Login')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('email')
                                    ->label('Email address')
                                    ->email()
                                    ->unique(User::class, 'email', ignoreRecord: true),


                                Forms\Components\TextInput::make('password')
                                    ->label('รหัสผ่าน')
                                    ->password()
                                    ->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
                                    ->minLength(8)
                                    ->same('passwordConfirmation')
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),

                                Forms\Components\TextInput::make('passwordConfirmation')
                                    ->label('ยืนยันรหัสผ่าน')
                                    ->password()
                                    ->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
                                    ->minLength(8)
                                    ->dehydrated(false),

                            ]),

                        Forms\Components\Toggle::make('active')->default(true)
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('avatar')
                        ->circular()->grow(false),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('nickname')
                            ->label('ชื่อเล่น')
                            ->weight('medium')
                            ->alignLeft(),

                        Tables\Columns\TextColumn::make('email')
                            ->label('Email address')
                            ->color('gray')
                            ->limit(25)
                            ->alignLeft(),
                    ])->space(),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('phone')
                            ->icon('eos-call')
                            ->color('blue')
                            ->label('โทร')
                            ->alignLeft(),

                        Tables\Columns\TextColumn::make('line_id')
                            ->icon('fab-line')
                            ->color('green')
                            ->label('line')
                            ->alignLeft(),
                    ])->space(2),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('dob')
                            ->icon('iconpark-birthdaycake-o')
                            ->color('blue')
                            ->label('วันเกิด')
                            ->alignLeft()
                            ->formatStateUsing(fn (string $state): string => thaidate('j M', "{$state}")),

                        Tables\Columns\TextColumn::make('doo')
                            ->icon('healthicons-f-temple')
                            ->color('green')
                            ->label('วันบวช')
                            ->alignLeft()
                            ->formatStateUsing(fn (string $state): string => thaidate('j M y', "{$state}")),
                    ])->space(2),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('roles.name')
                            ->icon('heroicon-o-finger-print')
                            ->color('blue')
                            ->label('สิทธิ')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('permissions.name')
                            ->icon('heroicon-o-key')
                            ->color('blue')
                            ->label('โปรแกรม')
                            ->alignLeft(),

                    ])->space(2),

                    Tables\Columns\IconColumn::make('active')->grow(false)
                        ->boolean(),
                    //ToggleColumn::make('active')->grow(false),

                ])->from('md'),
            ])->defaultSort(function (Builder $query): Builder {
                return $query
                    ->orderBy('active', 'desc')
                    ->orderBy('doo', 'asc');
            })


            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultGroup('status');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
