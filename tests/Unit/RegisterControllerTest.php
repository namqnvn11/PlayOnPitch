<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_registration_form()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function it_registers_a_new_user()
    {
        $this->withoutExceptionHandling();

        $userData = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '0123456789',
        ];

        $response = $this->post(route('register'), $userData);

//        $response->assertRedirect(route('verify-email'));

        // Kiểm tra người dùng đã được lưu vào cơ sở dữ liệu
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
            'phone' => '0123456789',
        ]);

        // Kiểm tra xem người dùng đã được xác thực hay chưa
        $this->assertAuthenticated();
    }

    /** @test */
    public function it_requires_valid_data_to_register()
    {
        $response = $this->post(route('register'), []);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'password',
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function it_requires_a_unique_email()
    {
        $existingUser = User::factory()->create([
            'email' => 'existing@example.com',
        ]);

        $response = $this->post(route('register'), [
            'name' => 'Another User',
            'email' => 'existing@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);

        $this->assertGuest();
    }

    /** @test */
    public function it_hashes_the_password_before_saving()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '0123456789',
        ];

        $this->post(route('register'), $userData);

        $user = User::where('email', 'testuser@example.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('password', $user->password));
    }

}
