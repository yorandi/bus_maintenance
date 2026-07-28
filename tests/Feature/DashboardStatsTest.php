<?php

namespace Tests\Feature;

use App\Models\Armada;
use App\Models\Role;
use App\Models\StatusArmada;
use App\Models\User;
use Tests\TestCase;

class DashboardStatsTest extends TestCase
{
    public function test_armada_status_summary_categories_match_total(): void
    {
        $operasional = StatusArmada::create(['nama_status' => 'Operasional']);
        $servis = StatusArmada::create(['nama_status' => 'Servis']);
        $rusak = StatusArmada::create(['nama_status' => 'Rusak']);
        $tidakBeroperasi = StatusArmada::create(['nama_status' => 'Tidak Beroperasi']);

        Armada::factory()->create(['status_armada_id' => $operasional->id, 'status' => 'good']);
        Armada::factory()->create(['status_armada_id' => $servis->id, 'status' => 'maintenance']);
        Armada::factory()->create(['status_armada_id' => $rusak->id, 'status' => 'damaged']);
        Armada::factory()->create(['status_armada_id' => $tidakBeroperasi->id, 'status' => 'inactive']);

        $summary = Armada::statusSummary();

        $this->assertSame(4, $summary['total']);
        $this->assertSame(1, $summary['aktif']);
        $this->assertSame(1, $summary['servis']);
        $this->assertSame(1, $summary['rusak']);
        $this->assertSame(1, $summary['tidak_beroperasi']);
        $this->assertSame(
            $summary['total'],
            $summary['aktif'] + $summary['servis'] + $summary['rusak'] + $summary['tidak_beroperasi']
        );
    }

    public function test_dashboard_uses_consistent_armada_status_summary(): void
    {
        $role = Role::create(['nama_role' => 'Admin', 'deskripsi' => 'Administrator']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $operasional = StatusArmada::create(['nama_status' => 'Operasional']);
        $rusak = StatusArmada::create(['nama_status' => 'Rusak']);
        $tidakBeroperasi = StatusArmada::create(['nama_status' => 'Tidak Beroperasi']);

        Armada::factory()->create(['status_armada_id' => $operasional->id, 'status' => 'good']);
        Armada::factory()->create(['status_armada_id' => $rusak->id, 'status' => 'damaged']);
        Armada::factory()->create(['status_armada_id' => $tidakBeroperasi->id, 'status' => 'inactive']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Total Armada');
        $response->assertSee('Beroperasi');
        $response->assertSee('Rusak');
        $response->assertSee('Tidak Beroperasi');
    }
}
