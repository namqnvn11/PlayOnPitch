<?php

namespace Database\Factories;

use App\Models\Boss;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Yard>
 */
class YardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'boss_id'=> Boss::pluck('id')->random(),
            'yard_name'=> 'sân số '. rand(1,10),
            'yard_type'=> $this->faker->randomElement([5,7,11]),
            'block'=> 0,
        ];
    }
}
