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
        Schema::table('pengantar', function (Blueprint $table) {
            // Perintah ini menghapus index unik dari kolom NIK
            // Nama 'pengantar_nik_unique' diambil dari pesan error Anda
            $table->dropUnique('pengantar_nik_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengantar', function (Blueprint $table) {
            // Ini untuk membatalkan (jika diperlukan), yaitu menambahkannya kembali
            $table->string('NIK')->unique();
        });
    }
};