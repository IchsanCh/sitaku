<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TierResource\Pages;
use App\Models\Feature;
use App\Models\Tier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TierResource extends Resource
{
    protected static ?string $model = Tier::class;

    protected static ?string $navigationGroup = 'Main';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tier Information')
                    ->columns(2)
                    ->description('Nama tier yang nanti dipasangin ke Package')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Tier Name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->placeholder('Contoh: Premium'),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->unique(ignoreRecord: true)
                            ->helperText('Auto-generate dari Tier Name.'),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->placeholder('Deskripsi singkat tier ini (opsional)'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Tier non-aktif gak akan bisa dipilih di Package baru.')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Fitur per Tier')
                    ->description('Semua fitur di bawah wajib diisi eksplisit buat tier ini — toggle nyala/mati, atau isi kuota (centang Unlimited kalau tanpa batas).')
                    ->schema(static::getFeatureFormComponents())
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    /**
     * Build 1 form component per Feature master (bukan repeater biasa),
     * biar admin WAJIB ngisi eksplisit semua fitur yang ada, bukan cuma
     * milih sebagian dari daftar. Statepath-nya "features.{feature_id}.*"
     * lalu di-sync manual ke pivot tier_feature lewat TierResource::syncFeatures()
     * yang dipanggil di CreateTier::afterCreate() / EditTier::afterSave().
     */
    public static function getFeatureFormComponents(): array
    {
        return Feature::query()
            ->orderBy('name')
            ->get()
            ->map(function (Feature $feature) {
                if ($feature->type === 'limit') {
                    return Forms\Components\Group::make([
                        Forms\Components\TextInput::make("features.{$feature->id}.value")
                            ->label($feature->name)
                            ->numeric()
                            ->minValue(0)
                            ->required(fn (Get $get) => ! $get("features.{$feature->id}.is_unlimited"))
                            ->disabled(fn (Get $get) => (bool) $get("features.{$feature->id}.is_unlimited"))
                            ->dehydrated() // tetep kekirim walau lagi disabled (pas unlimited dicentang)
                            ->helperText($feature->description ?: 'Kuota angka, mis. jumlah maksimal pegawai')
                            ->columnSpan(2),
                        Forms\Components\Toggle::make("features.{$feature->id}.is_unlimited")
                            ->label('Unlimited')
                            ->live()
                            ->inline(false)
                            ->columnSpan(1),
                    ])
                        ->columns(3)
                        ->columnSpanFull();
                }

                return Forms\Components\Toggle::make("features.{$feature->id}.enabled")
                    ->label($feature->name)
                    ->helperText($feature->description)
                    ->inline(false)
                    ->columnSpanFull();
            })
            ->all();
    }

    /**
     * Sync data form "features.*" (bukan kolom asli tabel tiers) ke pivot
     * tier_feature. Dipanggil manual dari page Create/Edit, BUKAN otomatis
     * lewat relationship(), soalnya kita perlu semua master Feature selalu
     * ke-cover, bukan cuma yang dipilih user.
     */
    public static function syncFeatures(Model $record, array $data): void
    {
        $features = Feature::all()->keyBy('id');
        $sync = [];

        foreach ($data['features'] ?? [] as $featureId => $row) {
            $feature = $features->get($featureId);

            if (! $feature) {
                continue;
            }

            if ($feature->type === 'limit') {
                $isUnlimited = (bool) ($row['is_unlimited'] ?? false);
                $sync[$featureId] = [
                    'value' => $isUnlimited ? null : ($row['value'] ?? 0),
                    'is_unlimited' => $isUnlimited,
                ];
            } else {
                $sync[$featureId] = [
                    'value' => ($row['enabled'] ?? false) ? '1' : '0',
                    'is_unlimited' => false,
                ];
            }
        }

        $record->features()->sync($sync);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tier Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('features_count')
                    ->label('Fitur Aktif')
                    ->counts('features')
                    ->sortable(),
                Tables\Columns\TextColumn::make('packages_count')
                    ->label('Dipakai di Package')
                    ->counts('packages')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
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
            'index' => Pages\ListTiers::route('/'),
            'create' => Pages\CreateTier::route('/create'),
            'edit' => Pages\EditTier::route('/{record}/edit'),
        ];
    }
}