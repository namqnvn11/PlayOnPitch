<?php
namespace Database\Factories;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReservationHistory>
 */
class ReservationHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'reservation_id' => Reservation::factory(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'canceled']),
        ];
    }
}
