<?php
namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Yard;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentTransactionFactory extends Factory
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
            'invoice_id' => Invoice::factory(),
            'transaction_id' => $this->faker->uuid(),
            'amount' => $this->faker->randomFloat(2, 1, 10000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'request_id' => $this->faker->uuid(),
            'payment_method' => $this->faker->randomElement(['momo', 'bank_transfer', 'paypal']),
            'response_data' => $this->faker->text(),
        ];
    }
}
