<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ["nama_role" => "Admin", "deskripsi" => "Mengelola seluruh data master dan pengguna sistem"],
            ["nama_role" => "Sopir", "deskripsi" => "Melakukan pemeriksaan kendaraan sebelum dan sesudah operasi"],
            ["nama_role" => "Mekanik", "deskripsi" => "Melaksanakan servis dan perbaikan armada"],
            ["nama_role" => "Manager Teknik", "deskripsi" => "Menyetujui jadwal servis dan memantau kondisi armada"],
        ];

        foreach ($roles as $role) {
            Role::query()->updateOrCreate(["nama_role" => $role["nama_role"]], $role);
        }
    }
}
