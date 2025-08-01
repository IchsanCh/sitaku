<?php

namespace App\Filament\Resources;

use Dom\Text;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Main';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Information')
                    ->columns(2)
                    ->description('Please Fill in the user details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter Username'),
                        TextInput::make('email')
                            ->label('Email')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->placeholder('Enter Email Address'),
                        TextInput::make('password')
                            ->password()
                            ->maxLength(255)
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => bcrypt($state))
                            ->required(fn(string $context): bool => $context === 'create')->revealable(),
                        DateTimePicker::make('email_verified_at')
                            ->label('Email Verify')
                            ->default(now())
                            ->placeholder('Select Date'),
                        DateTimePicker::make('subscription_expires_at')
                            ->label('subcription')
                            ->default(now())
                            ->placeholder('select subs'),
                        TextInput::make('subscription_token')
                            ->label('SITAKU Token'),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'active',
                                'inactive' => 'inactive',
                            ])
                            ->required(),
                        TextInput::make('unit_id')
                            ->label('Unit ID')
                            ->maxLength(255)
                            ->placeholder('Enter Unit ID'),
                        TextInput::make('api_url')
                            ->label('API URL')
                            ->maxLength(255)
                            ->placeholder('Enter API URL'),
                        TextInput::make('fonnte')
                            ->label('Fonnte')
                            ->maxLength(255)
                            ->placeholder('Enter Fonnte'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('email_verified_at')
                    ->label('Verified At')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->dateTime('d M Y H:i:s'),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->toggleable()
                    ->dateTime('d M Y')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
