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
        Schema::create('history_pasien_periksas', function (Blueprint $table) {
            $table->id();
            $table->integer('no_rm'); // ID pasien, foreign key ke tabel pasien
            $table->date('tanggal_periksa');     // Tanggal periksa
            $table->string('departemen');        // Departemen yang dituju
            $table->integer('dokter_id'); // Dokter yang menangani, foreign key ke tabel dokter
            $table->text('catatan')->nullable(); // Catatan tambahan (opsional)
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_pasien_periksas');
    }
};
