<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            "role_id" => fn () => Role::query()->inRandomOrder()->value("id"),
            "nama" => fake()->name(),
            "username" => fake()->unique()->userName(),
            "email" => fake()->unique()->safeEmail(),
            "no_hp" => fake()->numerify("08##########"),
            "password" => static::$password ??= Hash::make("password"),
            "status" => true,
            "remember_token" => Str::random(10),
        ];
    }
}
