<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::query()->where("nama_role", "Admin")->firstOrFail();
        $sopirRole = Role::query()->where("nama_role", "Sopir")->firstOrFail();
        $mekanikRole = Role::query()->where("nama_role", "Mekanik")->firstOrFail();
        $managerRole = Role::query()->where("nama_role", "Manager Teknik")->firstOrFail();

        User::query()->updateOrCreate(
            ["username" => "admin"],
            [
                "role_id" => $adminRole->id,
                "nama" => "Administrator Sistem",
                "email" => "admin@damri.co.id",
                "no_hp" => "081200000001",
                "password" => bcrypt("password"),
                "status" => true,
            ]
        );

        User::query()->updateOrCreate(
            ["username" => "manager.teknik"],
            [
                "role_id" => $managerRole->id,
                "nama" => "Bambang Setiawan",
                "email" => "manager.teknik@damri.co.id",
                "no_hp" => "081200000002",
                "password" => bcrypt("password"),
                "status" => true,
            ]
        );

        User::factory()->count(8)->state(["role_id" => $sopirRole->id])->create();
        User::factory()->count(4)->state(["role_id" => $mekanikRole->id])->create();
    }
}
