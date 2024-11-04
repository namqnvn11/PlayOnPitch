<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Boss>
 */
class BossFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'status' => rand(0, 1),
            'phone' => fake()->phoneNumber(),
            'company_name'=> fake()->company(),
            'company_address'=> fake()->address(),
            'district_id' => District::pluck('id')->random(),
            'block'=> rand(0, 1),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
