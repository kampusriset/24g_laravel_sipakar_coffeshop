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
        Schema::create('ai_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->cascadeOnDelete();
            $table->string('mood');
            $table->string('cuaca');
            $table->string('waktu');
            $table->string('jenis_minuman');
            $table->decimal('suka_susu', 3, 2);
            $table->decimal('suka_kopi', 3, 2);
            $table->decimal('suka_manis', 3, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_jawaban');
    }
};
