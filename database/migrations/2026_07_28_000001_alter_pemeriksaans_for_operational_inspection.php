<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemeriksaans', function (Blueprint $table) {
            if (!Schema::hasColumn('pemeriksaans', 'vehicle_id')) {
                $table->unsignedBigInteger('vehicle_id')->nullable()->after('armada_id');
            }

            if (!Schema::hasColumn('pemeriksaans', 'driver_id')) {
                $table->unsignedBigInteger('driver_id')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('pemeriksaans', 'type')) {
                $table->string('type')->nullable()->after('jenis');
            }

            if (!Schema::hasColumn('pemeriksaans', 'odometer')) {
                $table->integer('odometer')->nullable()->after('odometer_terakhir');
            }

            if (!Schema::hasColumn('pemeriksaans', 'checklist')) {
                $table->json('checklist')->nullable()->after('odometer');
            }

            if (!Schema::hasColumn('pemeriksaans', 'complaint')) {
                $table->text('complaint')->nullable()->after('checklist');
            }

            if (!Schema::hasColumn('pemeriksaans', 'condition_result')) {
                $table->string('condition_result')->nullable()->after('complaint');
            }

            if (!Schema::hasColumn('pemeriksaans', 'inspected_at')) {
                $table->timestamp('inspected_at')->nullable()->after('condition_result');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pemeriksaans', function (Blueprint $table) {
            $table->dropColumn(['vehicle_id', 'driver_id', 'type', 'odometer', 'checklist', 'complaint', 'condition_result', 'inspected_at']);
        });
    }
};
