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
        Schema::create('inventaris_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_path')->nullable(); // To store image path
            $table->text('description')->nullable();
            $table->integer('jumlah_masuk')->default(0); // Quantity of items entering
            $table->integer('jumlah_keluar')->default(0); // Quantity of items exiting
            $table->integer('total')->default(0); // Total items in stock
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_models');
    }
};
