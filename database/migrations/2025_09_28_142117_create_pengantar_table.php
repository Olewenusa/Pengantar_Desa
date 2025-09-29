<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengantar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resident_id');
            $table->string('name');
            $table->string('NIK')->unique();
            $table->string('purpose');
            $table->date('date');
            $table->enum('status_rt', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->enum('status_rw', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('report_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('notes_rt')->nullable(); // Catatan dari RT
            $table->text('notes_rw')->nullable(); // Catatan dari RW
            $table->timestamps();

            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengantar');
    }
};