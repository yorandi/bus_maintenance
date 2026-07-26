<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_laporan', 50)->unique(); // Dibatasi agar lebih optimal

            $table->foreignId('armada_id')
                ->constrained('armadas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('odometer_terakhir');
            $table->text('status');


            $table->enum('jenis', ['AT3', 'AT4']);
            $table->date('tanggal');
            $table->time('jam');
            $table->text('catatan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaans');
    }
};
