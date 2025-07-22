<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationGroup = 'Main';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Package Information')
                    ->columns(2)
                    ->description('Please Fill in the package details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Package Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter Package Name'),
                        Forms\Components\TextInput::make('description')
                            ->label('Description')
                            ->maxLength(500)
                            ->placeholder('Enter Package Description'),
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->required()
                            ->placeholder('Enter Package Price'),
                        Forms\Components\TextInput::make('duration_days')
                            ->label('Duration (in days)')
                            ->numeric()
                            ->required()
                            ->placeholder('Enter Duration in Days'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Package Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration_days')
                    ->label('Duration (Days)')
                    ->sortable()
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
