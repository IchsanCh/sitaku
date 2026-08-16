<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Package;
use App\Models\Pesan;
use Illuminate\Support\Str;
use App\Models\Subscription;
use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'pesan_pemohon',
        'pesan_penyerahan',
        'pesan_pegawai',
        'status',
        'email_verified_at',
        'unit_id',
        'active_api_version',
        'notif_pegawai',
        'notif_pemohon',
        'state_machine_pemohon',
        'state_machine_pegawai',
        'fonnte',
        'subscription_token',
        'subscription_expires_at',
        'active_package_id',
    ];
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }

    /**
     * Baris api_keys yang lagi aktif dipakai user ini, ditentukan dari
     * kolom users.active_api_version. Switch versi = ganti kolom ini aja,
     * gak perlu utak-atik data credential-nya.
     *
     * SENGAJA method biasa (bukan relasi Eloquent hasOne) -- relasi yang
     * constraint-nya bergantung ke $this->active_api_version TIDAK aman
     * di-eager-load (->with('activeApiKey')): Eloquent nyusun query eager
     * load-nya pake instance User KOSONG, jadi $this->active_api_version
     * selalu null di titik itu, hasilnya query "WHERE version = NULL" yg
     * sama buat semua user, bukan per-user. Cara amannya: eager-load
     * apiKeys() (hasMany biasa, gak ada dynamic constraint) terus filter
     * di PHP dari collection yang udah ke-load.
     */
    public function activeApiKey(): ?ApiKey
    {
        return $this->apiKeys->firstWhere('version', $this->active_api_version);
    }

    public function activePackage()
    {
        return $this->belongsTo(Package::class, 'active_package_id');
    }

    public function pesan()
    {
        return $this->hasMany(Pesan::class);
    }

    /**
     * Apakah masa langganan user masih aktif (belum expired).
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscription_expires_at !== null
            && $this->subscription_expires_at->isFuture();
    }

    /**
     * Tier yang lagi aktif buat user ini, null kalau langganan udah expired
     * atau belum pernah punya active package.
     */
    public function currentTier(): ?Tier
    {
        if (! $this->hasActiveSubscription()) {
            return null;
        }

        return $this->activePackage?->tier;
    }

    /**
     * Cek apakah user (lewat tier aktifnya) punya akses ke suatu fitur.
     */
    public function hasFeature(string $slug): bool
    {
        return $this->currentTier()?->hasFeature($slug) ?? false;
    }

    /**
     * Ambil limit angka fitur bertipe `limit` dari tier aktif user.
     * Null = unlimited ATAU tier-nya emang gak ada (cek hasFeature dulu buat mastiin).
     */
    public function featureLimit(string $slug): ?int
    {
        return $this->currentTier()?->featureLimit($slug);
    }

    /**
     * Daftar action_type yang boleh dipake user ini buat custom menu WA-nya.
     * Base actions (cek_status, riwayat_tahapan, exit) otomatis kebuka asal
     * tier-nya punya feature 'state_machine' (master gate custom menu).
     * Premium actions (pesan_custom, submenu) baru nambah kalau tier-nya
     * punya feature spesifik masing-masing.
     */
    public function allowedMenuActionTypes(): array
    {
        if (! $this->hasFeature('state_machine')) {
            return [];
        }

        $allowed = \App\Models\MenuItem::BASE_ACTIONS;

        foreach (\App\Models\MenuItem::PREMIUM_ACTIONS as $actionType => $featureSlug) {
            if ($this->hasFeature($featureSlug)) {
                $allowed[] = $actionType;
            }
        }

        return $allowed;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'timestamp',
        'password' => 'hashed',
        'subscription_expires_at' => 'datetime',
    ];
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->subscription_token = Str::random(20);
            $user->webhook_token = Str::random(32);
        });
    }
}