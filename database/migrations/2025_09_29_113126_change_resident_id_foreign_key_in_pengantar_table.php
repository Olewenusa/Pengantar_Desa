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
            // Langkah 1: Hapus foreign key lama yang salah
            // Nama 'pengantar_resident_id_foreign' diambil dari pesan error Anda
            $table->dropForeign('pengantar_resident_id_foreign');

            // Langkah 2: Tambahkan foreign key baru yang benar (ke tabel 'users')
            $table->foreign('resident_id')
                  ->references('id')
                  ->on('users') // Mengarah ke tabel 'users'
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengantar', function (Blueprint $table) {
            // Langkah 1 (dibalik): Hapus foreign key yang baru
            $table->dropForeign('pengantar_resident_id_foreign');

            // Langkah 2 (dibalik): Tambahkan kembali foreign key yang lama (ke tabel 'residents')
            $table->foreign('resident_id')
                  ->references('id')
                  ->on('residents')
                  ->onDelete('cascade');
        });
    }
};