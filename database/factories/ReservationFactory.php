<?php
namespace Database\Factories;

use App\Models\User;
use App\Models\Yard;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
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
//            'yard_id' => Yard::factory(),
            'reservation_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'deposit_amount' => $this->faker->numberBetween(1000, 10000),
            'payment_status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'reservation_status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'total_price' => $this->faker->numberBetween(10000, 100000),
            'code' => $this->faker->unique()->word,
            'payment_type' => $this->faker->randomElement(['full','deposit']),
            'contact_id' => Contact::factory(),
        ];
    }
}
