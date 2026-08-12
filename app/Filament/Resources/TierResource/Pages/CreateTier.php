<?php

namespace App\Filament\Resources\TierResource\Pages;

use App\Filament\Resources\TierResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTier extends CreateRecord
{
    protected static string $resource = TierResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Tier Created';
    }

    /**
     * 'features' bukan kolom asli tabel tiers, jadi dibuang dulu sebelum
     * dipakai buat Tier::create() -- nanti ke-sync manual di afterCreate().
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['features']);

        return $data;
    }

    protected function afterCreate(): void
    {
        TierResource::syncFeatures($this->record, $this->data);
    }
}