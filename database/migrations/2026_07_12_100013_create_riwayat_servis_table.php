<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_servis', function (Blueprint $table) {

            $table->id();

            $table->foreignId('vehicle_id')
                ->nullable()
                ->constrained('armadas')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('schedule_id')
                ->nullable()
                ->constrained('jadwal_servis')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('jadwal_servis_id')
                ->constrained('jadwal_servis')
                ->cascadeOnDelete();

            $table->foreignId('mekanik_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('mechanic_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->date('maintenance_date')->nullable();
            $table->date('tanggal_servis');

            $table->string('service_type')->nullable();

            $table->text('description')->nullable();

            $table->text('pekerjaan');

            $table->decimal('cost', 15, 2)->nullable();
            $table->decimal('biaya', 15, 2)->default(0);

            $table->text('parts_used')->nullable();

            $table->integer('odometer_reading')->nullable();

            $table->text('notes')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_servis');
    }
};
