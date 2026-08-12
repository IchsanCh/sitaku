<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete(); // 1 user = 1 api key aktif
            $table->string('api_url'); // pindahan dari users.api_url
            $table->string('bearer_token'); // dikirim di header Authorization: Bearer <token>
            $table->string('apikey'); // dikirim di header apikey
            $table->uuid('key_uuid')->unique(); // api key uuid dari sisi API/integrasi eksternal
            $table->string('salt_key'); // disimpen plain, decrypt dilakukan di luar sistem ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};