<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('live_chat_messages', function (Blueprint $table) {
            // Attachment (masuk dari pemohon ATAU keluar dari admin).
            // Sengaja disimpen sebagai URL apa adanya buat yang dari pemohon (URL Fonnte),
            // tapi buat yang admin upload, ini nunjuk ke storage disk publik kita sendiri.
            $table->string('media_url')->nullable()->after('message');
            $table->string('media_filename')->nullable()->after('media_url');
            $table->string('media_extension', 20)->nullable()->after('media_filename');

            // ID inbox Fonnte dari pesan MASUK ini -- dipakai kalau admin mau reply/quote
            // pesan spesifik ini, dikirim balik sebagai parameter `inboxid` ke API send Fonnte
            // biar WA nampilin bubble reply beneran (bukan cuma quote teks manual).
            $table->string('fonnte_inbox_id')->nullable()->after('fonnte_message_id');

            // Reply-to internal kita sendiri (buat nampilin quoted snippet di UI kita),
            // terpisah dari fonnte_inbox_id di atas -- ini jalan buat quote ke pesan
            // manapun (termasuk pesan admin lain), fonnte_inbox_id cuma jalan pas quote-nya
            // ke pesan pemohon.
            $table->foreignId('reply_to_message_id')->nullable()->after('fonnte_inbox_id')
                ->constrained('live_chat_messages')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('live_chat_messages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reply_to_message_id');
            $table->dropColumn(['media_url', 'media_filename', 'media_extension', 'fonnte_inbox_id']);
        });
    }
};