<?php

namespace Tests\Feature;

use App\Models\OperationalInspection;
use App\Models\User;
use Tests\TestCase;

class OperationalInspectionTest extends TestCase
{
    public function test_inspections_index_renders_when_related_vehicle_or_driver_is_missing(): void
    {
        $user = User::factory()->create();

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
}
