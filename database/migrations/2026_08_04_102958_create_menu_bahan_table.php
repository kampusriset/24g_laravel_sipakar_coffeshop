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
        Schema::create('menu_bahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menu')->cascadeOnDelete();
            $table->foreignId('stok_bahan_id')->constrained('stok_bahan')->cascadeOnDelete();
            $table->decimal('jumlah_pakai', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_bahan');
    }
};
