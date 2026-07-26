<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\FonnteService;

class MaintenanceController extends Controller
{
    public function kirimTest(FonnteService $fonnte)
    {
        $result = $fonnte->send('6281234567890', 'Halo, ini pesan test dari sistem maintenance bus.');

        return response()->json($result);
    }
}
