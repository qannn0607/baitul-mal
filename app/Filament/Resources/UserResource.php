<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Data Muzakki & User';

    protected static ?string $pluralModelLabel = 'Muzakki & User';

    protected static ?string $modelLabel = 'Muzakki';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->label('Nama Lengkap'),

                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->maxLength(30)
                    ->label('Nomor HP / WhatsApp'),

                Forms\Components\TextInput::make('place_of_birth')
                    ->required()
                    ->maxLength(255)
                    ->label('Tempat Lahir'),

                Forms\Components\DatePicker::make('date_of_birth')
                    ->required()
                    ->label('Tanggal Lahir'),

                Forms\Components\Select::make('role')
                    ->options([
                        'user' => 'Muzakki (User)',
                        'admin' => 'Administrator',
                    ])
                    ->default('user')
                    ->required()
                    ->label('Peran (Role)'),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->label('Password'),

                Forms\Components\Textarea::make('address')
                    ->required()
                    ->columnSpanFull()
                    ->label('Alamat Lengkap'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->label('Nama Lengkap'),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->label('No. HP'),

                Tables\Columns\TextColumn::make('place_of_birth')
                    ->label('Tempat Lahir'),

                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date('d M Y')
                    ->label('Tgl Lahir'),

                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'user' => 'success',
                        default => 'gray',
                    })
                    ->label('Role'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->label('Terdaftar'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'user' => 'Muzakki (User)',
                        'admin' => 'Administrator',
                    ]),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
