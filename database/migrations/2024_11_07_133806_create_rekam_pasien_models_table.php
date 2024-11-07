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
        Schema::create('rekam_pasien_models', function (Blueprint $table) {
            $table->id();
            $table->integer('pasienId');
            $table->integer('dokterId');
            $table->string('diagnoosa');
            $table->string('tindakan');
            $table->string('obat');
            $table->string('biaya');
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
        Schema::dropIfExists('rekam_pasien_models');
    }
};
