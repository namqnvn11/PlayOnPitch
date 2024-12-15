<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // mật khẩu giả định
            'status' => rand(0, 1),
            'phone' => $this->faker->phoneNumber(),
            'company_name' => $this->faker->company(),
            'company_address' => $this->faker->address(),
            'district_id' => 1,
            'block' => 0,
            'time_open' => rand(0, 1),
            'time_close' => rand(0, 1),
            'is_open_all_day' => rand(0, 1),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
