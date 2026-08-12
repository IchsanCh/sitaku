<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiKeyResource\Pages;
use App\Models\ApiKey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ApiKeyResource extends Resource
{
    protected static ?string $model = ApiKey::class;

    protected static ?string $navigationGroup = 'Main';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationLabel = 'API Keys';
    protected static ?string $modelLabel = 'API Key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('API Key Information')
                    ->columns(2)
                    ->description('Kredensial integrasi eksternal per user. Cuma admin yang bisa isi/edit ini.')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('1 user cuma boleh punya 1 API key aktif.')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('api_url')
                            ->label('API URL')
                            ->url()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('https://example.com/api/pemohon')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('bearer_token')
                            ->label('Bearer Token')
                            ->required()
                            ->maxLength(255)
                            ->password()
                            ->revealable()
                            ->helperText('Dikirim di header Authorization: Bearer <token>'),
                        Forms\Components\TextInput::make('apikey')
                            ->label('API Key')
                            ->required()
                            ->maxLength(255)
                            ->password()
                            ->revealable()
                            ->helperText('Dikirim di header apikey'),
                        Forms\Components\TextInput::make('key_uuid')
                            ->label('Key UUID')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('UUID dari sisi API/integrasi eksternal (bukan digenerate sistem ini).'),
                        Forms\Components\TextInput::make('salt_key')
                            ->label('Salt Key')
                            ->required()
                            ->maxLength(255)
                            ->password()
                            ->revealable()
                            ->helperText('Disimpen apa adanya (plain), decrypt-nya dilakukan di luar sistem ini.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('api_url')
                    ->label('API URL')
                    ->limit(40)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('key_uuid')
                    ->label('Key UUID')
                    ->badge()
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // bearer_token, apikey, salt_key sengaja gak ditampilin di table
                // (kredensial sensitif) -- cuma keliatan pas buka form edit.
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
            'index' => Pages\ListApiKeys::route('/'),
            'create' => Pages\CreateApiKey::route('/create'),
            'edit' => Pages\EditApiKey::route('/{record}/edit'),
        ];
    }
}