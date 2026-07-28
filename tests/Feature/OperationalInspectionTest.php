<?php

namespace Tests\Feature;

use App\Models\Armada;
use App\Models\OperationalInspection;
use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class OperationalInspectionTest extends TestCase
{
    public function test_inspections_index_renders_when_related_vehicle_or_driver_is_missing(): void
    {
        Role::create(['nama_role' => 'Sopir', 'deskripsi' => 'Driver']);
        $user = User::factory()->create(['role_id' => Role::where('nama_role', 'Sopir')->value('id')]);

        OperationalInspection::create([
            'vehicle_id' => 999999,
            'driver_id' => 999999,
            'type' => 'at3',
            'odometer' => 1200,
            'checklist' => ['stnk' => 'baik'],
            'complaint' => null,
            'condition_result' => 'siap_operasi',
            'inspected_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/inspections');

        $response->assertOk();
        $response->assertSee('AT/3');
    }

    public function test_admin_can_open_at3_and_at4_create_pages(): void
    {
        Role::create(['nama_role' => 'Admin', 'deskripsi' => 'Administrator']);
        $user = User::factory()->create(['role_id' => Role::where('nama_role', 'Admin')->value('id')]);

        $at3Response = $this->actingAs($user)->get('/inspections/at3/create');
        $at4Response = $this->actingAs($user)->get('/inspections/at4/create');

        $at3Response->assertOk();
        $at3Response->assertSee('AT/3 Digital');
        $at4Response->assertOk();
        $at4Response->assertSee('AT/4 Digital');
    }

    public function test_admin_can_open_short_at3_and_at4_create_pages(): void
    {
        Role::create(['nama_role' => 'Admin', 'deskripsi' => 'Administrator']);
        $user = User::factory()->create(['role_id' => Role::where('nama_role', 'Admin')->value('id')]);

        $at3Response = $this->actingAs($user)->get('/at3/create');
        $at4Response = $this->actingAs($user)->get('/at4/create');

        $at3Response->assertOk();
        $at3Response->assertSee('AT/3 Digital');
        $at4Response->assertOk();
        $at4Response->assertSee('AT/4 Digital');
    }

    public function test_driver_can_store_at3_and_at4_inspections_with_valid_vehicle(): void
    {
        Role::create(['nama_role' => 'Sopir', 'deskripsi' => 'Driver']);
        $user = User::factory()->create(['role_id' => Role::where('nama_role', 'Sopir')->value('id')]);
        $vehicle = Armada::factory()->create();

        $response = $this->actingAs($user)->post('/inspections/at3', [
            'vehicle_id' => $vehicle->id,
            'odometer' => 1500,
            'checklist' => [
                'stnk' => 'baik',
                'pajak_tahunan' => 'baik',
                'keur' => 'baik',
                'kps' => 'baik',
                'lampu_dekat' => 'baik',
                'lampu_jauh' => 'baik',
                'lampu_sein' => 'baik',
                'lampu_rem' => 'baik',
                'sistem_pengereman' => 'baik',
                'kondisi_rem_utama' => 'baik',
                'kondisi_ban_depan' => 'baik',
                'kondisi_ban_belakang' => 'baik',
                'penghapus_kaca' => 'baik',
                'apar' => 'baik',
                'kotak_obat' => 'baik',
                'kunci_roda' => 'baik',
                'dongkrak' => 'baik',
                'ban_serep' => 'baik',
                'kaki_seat' => 'baik',
                'jok_duduk' => 'baik',
                'jok_sandaran' => 'baik',
                'bagasi_kanan' => 'baik',
                'bagasi_kiri' => 'baik',
                'semua_kaca' => 'baik',
                'bodi_luar' => 'baik',
                'air_radiator' => 'baik',
                'oli_mesin' => 'baik',
                'minyak_rem_kopling' => 'baik',
                'minyak_steering' => 'baik',
                'starter_motor' => 'baik',
                'bunyi_mesin' => 'baik',
                'klakson' => 'baik',
                'gejala_abnormal' => 'baik',
                'indikator_mesin' => 'baik',
                'meter_oli' => 'baik',
                'meter_bahan_bakar' => 'baik',
                'meter_pengisian_battery' => 'baik',
                'tachometer' => 'baik',
                'tekanan_angin' => 'baik',
                'speedometer' => 'baik',
                'odometer_instrument' => 'baik',
                'lampu_bawah_kiri_depan' => 'baik',
                'lampu_bawah_kanan_depan' => 'baik',
                'lampu_atas_kiri_depan' => 'baik',
                'lampu_atas_kanan_depan' => 'baik',
                'lampu_samping_kiri_depan' => 'baik',
                'lampu_samping_kanan_depan' => 'baik',
                'lampu_kiri_belakang' => 'baik',
                'lampu_kanan_belakang' => 'baik',
                'lampu_kiri_depan' => 'baik',
                'lampu_kanan_depan' => 'baik',
                'lampu_dashboard' => 'baik',
                'lampu_interior' => 'baik',
            ],
            'complaint' => null,
        ]);

        $response->assertRedirect();
        $this->actingAs($user)->get($response->headers->get('Location'))->assertOk();

        $this->assertDatabaseHas('pemeriksaans', [
            'vehicle_id' => $vehicle->id,
            'driver_id' => $user->id,
            'type' => 'at3',
            'odometer' => 1500,
        ]);

        $at4Response = $this->actingAs($user)->post('/inspections/at4', [
            'vehicle_id' => $vehicle->id,
            'odometer' => 1750,
            'checklist' => [
                'mesin' => 'baik',
                'sistem_rem' => 'baik',
                'sistem_kemudi' => 'baik',
                'sistem_pending' => 'baik',
                'suspensi' => 'baik',
                'elektrikal' => 'baik',
                'sistem_kopling' => 'baik',
                'transmisi' => 'baik',
                'roda_roda' => 'baik',
                'kebersihan' => 'baik',
                'body_kendaraan' => 'baik',
                'sistem_ac' => 'baik',
            ],
            'complaint' => null,
        ]);

        $at4Response->assertRedirect();
        $this->actingAs($user)->get($at4Response->headers->get('Location'))->assertOk();

        $this->assertDatabaseHas('pemeriksaans', [
            'vehicle_id' => $vehicle->id,
            'driver_id' => $user->id,
            'type' => 'at4',
            'odometer' => 1750,
        ]);
    }
}
