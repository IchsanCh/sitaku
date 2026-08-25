<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ganti bearer_token, apikey, salt_key dari VARCHAR(255) jadi TEXT.
     * Pake raw SQL (bukan Blueprint::change()) biar gak butuh doctrine/dbal.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE api_keys MODIFY bearer_token TEXT NOT NULL');
        DB::statement('ALTER TABLE api_keys MODIFY apikey TEXT NOT NULL');
        DB::statement('ALTER TABLE api_keys MODIFY salt_key TEXT NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE api_keys MODIFY bearer_token VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE api_keys MODIFY apikey VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE api_keys MODIFY salt_key VARCHAR(255) NOT NULL');
    }
};