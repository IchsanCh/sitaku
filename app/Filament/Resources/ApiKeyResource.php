<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiKeyResource\Pages;
use App\Models\ApiKey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
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
                            ->helperText('1 user boleh punya beberapa credential (misal v2 & v3 bareng) -- pilih yang aktif lewat aksi "Jadikan Aktif" di tabel.')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('version')
                            ->label('Version')
                            ->required()
                            ->default('v3')
                            ->maxLength(255)
                            ->unique(
                                table: 'api_keys',
                                column: 'version',
                                ignoreRecord: true,
                                modifyRuleUsing: fn (\Illuminate\Validation\Rules\Unique $rule, Get $get) => $rule->where('user_id', $get('user_id')),
                            )
                            ->helperText('1 user gak boleh punya 2 credential versi yang sama (mis. dua-duanya "v3").')
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
                            ->password()
                            ->revealable()
                            ->helperText('Dikirim di header Authorization: Bearer <token>. Kolom udah TEXT, jadi gak dibatasin 255 karakter.'),
                        Forms\Components\TextInput::make('apikey')
                            ->label('API Key')
                            ->required()
                            ->password()
                            ->revealable()
                            ->helperText('Dikirim di header apikey. Kolom udah TEXT, jadi gak dibatasin 255 karakter.'),
                        Forms\Components\TextInput::make('key_uuid')
                            ->label('Key UUID')
                            ->required()
                            ->maxLength(255)
                            ->helperText('UUID dari sisi API/integrasi eksternal (bukan digenerate sistem ini). Gak wajib unik -- boleh sama antar baris.'),
                        Forms\Components\TextInput::make('salt_key')
                            ->label('Salt Key')
                            ->required()
                            ->password()
                            ->revealable()
                            ->helperText('Disimpen apa adanya (plain), decrypt-nya dilakukan di luar sistem ini. Kolom udah TEXT, jadi gak dibatasin 255 karakter.'),
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
                Tables\Columns\TextColumn::make('version')
                    ->label('Version')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->state(fn (ApiKey $record): bool => $record->version === $record->user?->active_api_version),
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
                Tables\Actions\Action::make('setActive')
                    ->label('Jadikan Aktif')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (ApiKey $record): bool => $record->version !== $record->user?->active_api_version)
                    ->action(function (ApiKey $record) {
                        $record->user?->update(['active_api_version' => $record->version]);
                    })
                    ->successNotificationTitle('Versi aktif user berhasil diganti'),
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