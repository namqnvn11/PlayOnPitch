<?php

namespace Database\Factories;

use App\Models\YardSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\YardSchedule>
 */
class YardScheduleFactory extends Factory
{
    protected $model = YardSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'yard_id' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->date(),
            'price_per_hour' => $this->faker->numberBetween(50, 200),
            'time_slot' => $this->faker->time(),
            'status' => $this->faker->randomElement(['available', 'booked', 'pending']),
            'reservation_id' => $this->faker->numberBetween(1, 50),
            'block' => 0,
        ];
    }
}
