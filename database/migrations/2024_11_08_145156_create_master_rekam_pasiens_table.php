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
        Schema::create('master_rekam_pasiens', function (Blueprint $table) {
            $table->id();
            $table->integer('riwayatId');
            $table->integer('pasienId');
            $table->integer('dokterId');
            $table->string('tindakan');
            $table->string('obat');
            $table->string('total');
            $table->string('createdBy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_rekam_pasiens');
    }
};
