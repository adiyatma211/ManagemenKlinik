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
        Schema::create('pasien_models', function (Blueprint $table) {
            $table->id('no_rm'); // Auto-increment primary key
            $table->string('nama_pasien')->nullable();
            $table->string('alamat')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('no_telp')->nullabke();
            $table->date('tgllahir')->nullable();
            $table->integer('umur')->nullable();
            $table->dateTime('tgl_masuk')->nullable();
            $table->dateTime('tgl_periksa')->nullable();
            $table->string('departemen')->nullable();
            $table->string('daftarDokter')->nullable();
            $table->string('createdBy')->nullable();
            $table->string('updatedBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien_models');
    }
};
