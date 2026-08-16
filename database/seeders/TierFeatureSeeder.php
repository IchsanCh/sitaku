<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Tier;
use Illuminate\Database\Seeder;

class TierFeatureSeeder extends Seeder
{
    /**
     * Seed master Feature + Tier (Basic/Premium) beserta pivot-nya.
     *
     * Pake updateOrCreate/sync biar aman di-run ulang (idempotent) -- gak
     * bikin duplikat kalau seeder ini dijalanin lagi setelah datanya diubah
     * manual lewat Filament.
     */
    public function run(): void
    {
        // ── Master Feature ───────────────────────────────────────────────
        $customPesan = Feature::updateOrCreate(
            ['slug' => 'custom_pesan'],
            [
                'name' => 'Custom Pesan',
                'type' => 'toggle',
                'description' => 'Bisa custom template pesan WA ke pemohon & pegawai.',
            ]
        );

        $apiAccess = Feature::updateOrCreate(
            ['slug' => 'api_access'],
            [
                'name' => 'Akses API / Integrasi',
                'type' => 'toggle',
                'description' => 'Data user ikut diproses cron sync & integrasi otomatis (avera).',
            ]
        );

        $maxPegawai = Feature::updateOrCreate(
            ['slug' => 'max_pegawai'],
            [
                'name' => 'Max Pegawai',
                'type' => 'limit',
                'description' => 'Batas maksimal jumlah pegawai yang bisa ditambahkan.',
            ]
        );

        $stateMachine = Feature::updateOrCreate(
            ['slug' => 'state_machine'],
            [
                'name' => 'State Machine Tracking',
                'type' => 'toggle',
                'description' => 'Custom menu WA (cek status, riwayat tahapan, exit) buat pemohon & pegawai. Master gate -- mati berarti gak ada custom menu sama sekali.',
            ]
        );

        $menuActionPesanCustom = Feature::updateOrCreate(
            ['slug' => 'menu_action_pesan_custom'],
            [
                'name' => 'Menu: Pesan Custom',
                'type' => 'toggle',
                'description' => 'Buka action_type "pesan_custom" di custom menu builder -- instansi bisa tulis pesan sendiri per menu item. Butuh State Machine Tracking nyala juga.',
            ]
        );

        $menuActionSubmenu = Feature::updateOrCreate(
            ['slug' => 'menu_action_submenu'],
            [
                'name' => 'Menu: Submenu',
                'type' => 'toggle',
                'description' => 'Buka action_type "submenu" di custom menu builder -- instansi bisa bikin menu bertingkat sendiri. Butuh State Machine Tracking nyala juga.',
            ]
        );

        // ── Tier: Basic ──────────────────────────────────────────────────
        // Custom Pesan & API access tetep nyala, cuma pegawai dibatasin 15
        // dan belum dapet State Machine.
        $basic = Tier::updateOrCreate(
            ['slug' => 'basic'],
            [
                'name' => 'Basic',
                'description' => 'Paket dasar -- fitur inti lengkap, jumlah pegawai dibatasin.',
                'is_active' => true,
            ]
        );

        $basic->features()->sync([
            $customPesan->id => ['value' => '1', 'is_unlimited' => false],
            $apiAccess->id => ['value' => '1', 'is_unlimited' => false],
            $maxPegawai->id => ['value' => '15', 'is_unlimited' => false],
            $stateMachine->id => ['value' => '0', 'is_unlimited' => false],
            $menuActionPesanCustom->id => ['value' => '0', 'is_unlimited' => false],
            $menuActionSubmenu->id => ['value' => '0', 'is_unlimited' => false],
        ]);

        // ── Tier: Premium ────────────────────────────────────────────────
        // Full access -- custom menu kebuka (Level 1: susun ulang label/urutan
        // dari action base), tapi pesan_custom & submenu masih terkunci --
        // itu pembeda buat Enterprise.
        $premium = Tier::updateOrCreate(
            ['slug' => 'premium'],
            [
                'name' => 'Premium',
                'description' => 'Full access -- semua fitur inti nyala, custom menu WA level dasar (belum bisa pesan custom / submenu).',
                'is_active' => true,
            ]
        );

        $premium->features()->sync([
            $customPesan->id => ['value' => '1', 'is_unlimited' => false],
            $apiAccess->id => ['value' => '1', 'is_unlimited' => false],
            $maxPegawai->id => ['value' => null, 'is_unlimited' => true],
            $stateMachine->id => ['value' => '1', 'is_unlimited' => false],
            $menuActionPesanCustom->id => ['value' => '0', 'is_unlimited' => false],
            $menuActionSubmenu->id => ['value' => '0', 'is_unlimited' => false],
        ]);

        // ── Tier: Enterprise ─────────────────────────────────────────────
        // Level 2 penuh -- instansi bisa susun menu WA custom sepenuhnya,
        // termasuk nulis pesan sendiri & bikin submenu bertingkat.
        $enterprise = Tier::updateOrCreate(
            ['slug' => 'enterprise'],
            [
                'name' => 'Enterprise',
                'description' => 'Full access + custom menu WA penuh (pesan custom & submenu bertingkat).',
                'is_active' => true,
            ]
        );

        $enterprise->features()->sync([
            $customPesan->id => ['value' => '1', 'is_unlimited' => false],
            $apiAccess->id => ['value' => '1', 'is_unlimited' => false],
            $maxPegawai->id => ['value' => null, 'is_unlimited' => true],
            $stateMachine->id => ['value' => '1', 'is_unlimited' => false],
            $menuActionPesanCustom->id => ['value' => '1', 'is_unlimited' => false],
            $menuActionSubmenu->id => ['value' => '1', 'is_unlimited' => false],
        ]);
    }
}