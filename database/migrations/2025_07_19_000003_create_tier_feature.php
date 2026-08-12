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
        Schema::create('tier_feature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('feature_id')->constrained()->cascadeOnDelete();

            // Buat type=toggle: '1' / '0'. Buat type=limit: angka kuota (mis. "10").
            // Nullable karena kalau is_unlimited true, value ga relevan.
            $table->string('value')->nullable();

            // Khusus type=limit — kalau true, feature ini dianggap tanpa batas
            // (dicek duluan sebelum baca `value`, jadi ga perlu angka sihir kayak -1).
            $table->boolean('is_unlimited')->default(false);

            $table->timestamps();

            $table->unique(['tier_id', 'feature_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tier_feature');
    }
};