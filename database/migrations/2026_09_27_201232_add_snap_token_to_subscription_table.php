<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Nullable by design -- baris subscription lama (sebelum kolom ini ada)
     * gak punya snap_token, dan itu valid (bukan data korup). BillingController
     * nanganin baris kayak gitu secara eksplisit: coba generate ulang snap
     * token sekali (self-heal), gagal generate ulang -> user diarahin balik
     * ke halaman billing dengan pesan "sesi pembayaran gak valid", bukan
     * fatal error / halaman putih.
     */
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('snap_token')->nullable()->after('payment_token');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('snap_token');
        });
    }
};