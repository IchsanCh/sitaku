<?php

namespace App\Filament\Resources\TierResource\Pages;

use App\Filament\Resources\TierResource;
use App\Models\Feature;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTier extends EditRecord
{
    protected static string $resource = TierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Tier Success Edited';
    }

    /**
     * Isi ulang state form "features.*" dari pivot tier_feature yang udah
     * ada, biar pas edit form-nya nunjukin nilai yang sekarang tersimpan
     * (bukan kosong semua). Fitur master yang belum pernah di-attach ke
     * tier ini (mis. fitur baru yg baru ditambah) otomatis kosong -> admin
     * wajib isi eksplisit sebelum bisa save (required tetep jalan).
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['features'] = $this->record->features->mapWithKeys(function (Feature $feature) {
            return [
                $feature->id => [
                    'enabled' => $feature->pivot->value === '1',
                    'value' => $feature->pivot->is_unlimited ? null : $feature->pivot->value,
                    'is_unlimited' => (bool) $feature->pivot->is_unlimited,
                ],
            ];
        })->all();

        return $data;
    }

    /**
     * 'features' bukan kolom asli tabel tiers -- dibuang dulu sebelum
     * $record->update(), nanti ke-sync manual di afterSave().
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['features']);

        return $data;
    }

    protected function afterSave(): void
    {
        TierResource::syncFeatures($this->record, $this->data);
    }
}