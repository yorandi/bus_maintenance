<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_servis', function (Blueprint $table) {

            $table->id();

            $table->foreignId('vehicle_id')
                ->nullable()
                ->constrained('armadas')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('armada_id')
                ->constrained('armadas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('scheduled_date')->nullable();

            $table->date('tanggal_servis');

            $table->foreignId('jenis_servis_id')
                ->constrained('jenis_servis')
                ->restrictOnDelete();

            $table->string('service_type')->nullable();

            $table->integer('km_servis')->nullable();

            $table->enum('status', [
                'Menunggu',
                'Proses',
                'Selesai',
                'Dibatalkan'
            ])->default('Menunggu');

            $table->string('prioritas');

            $table->string('assigned_mechanic')->nullable();

            $table->text('keterangan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_servis');
    }
};
