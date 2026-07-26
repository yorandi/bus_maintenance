<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('armadas', function (Blueprint $table) {

            $table->id();

            $table->string('kode_armada')->unique();

            $table->string('registration_number')->nullable()->unique();

            $table->string('nomor_rangka')->unique();

            $table->string('nomor_mesin')->unique();

            $table->string('nomor_polisi')->unique();

            $table->string('merk');

            $table->string('model')->nullable();

            $table->string('tipe');

            $table->integer('tahun_pembuatan')->nullable();

            $table->year('tahun');

            $table->integer('kapasitas_penumpang')->nullable();

            $table->integer('kapasitas');

            $table->date('date_operation_started')->nullable();

            $table->integer('odometer')->default(0);

            $table->integer('odometer_terakhir');

            $table->string('status')->nullable();

            $table->text('notes')->nullable();

            $table->foreignId('status_armada_id')
                ->constrained('status_armadas')
                ->restrictOnDelete();

            $table->timestamps();

            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('armadas');
    }
};
