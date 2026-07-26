<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan_details', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel induk (Pemeriksaan)
            $table->foreignId('pemeriksaan_id')->constrained('pemeriksaans')->cascadeOnDelete();

            // Relasi ke tabel komponen yang diperiksa
            $table->foreignId('komponen_id')->constrained('komponens')->restrictOnDelete();

            // Relasi ke status kondisi
            $table->foreignId('status_kondisi_id')->constrained('status_kondisis')->restrictOnDelete();

            $table->text('catatan')->nullable(); // Tambahkan kolom untuk keterangan detail
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_details');
    }
};
