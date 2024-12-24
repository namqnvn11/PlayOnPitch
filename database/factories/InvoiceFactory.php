<?php
namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(), // Tạo liên kết với Reservation
            'invoice_date' => $this->faker->dateTimeThisYear(),
            'total_price' => $this->faker->randomFloat(2, 50, 1000),
            'payment_method' => $this->faker->randomElement(['credit_card', 'momo', 'cash']),
            'status' => $this->faker->randomElement(['pending', 'completed', 'canceled']),
        ];
    }
}
