<?php
namespace Tests\Unit;

use App\Models\Admin;
use App\Models\Boss;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_logout_as_admin()
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password')]);

        $this->actingAs($admin, 'admin');

        $response = $this->get(route('admin.logout'));

        $response->assertRedirect(route('admin-boss.login'));
        $this->assertGuest('admin');
    }

    /** @test */
    public function test_logout_as_boss()
    {
        $boss = Boss::factory()->create([
            'email' => 'boss@example.com',
            'password' => bcrypt('password')]);

        $this->actingAs($boss, 'boss');

        $response = $this->get(route('boss.logout'));

        $response->assertRedirect(route('admin-boss.login'));
        $this->assertGuest('boss');
    }

    /** @test */
    public function test_logout_as_user()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => 'password'
        ]);

        $this->actingAs($user);

        $response = $this->get(route('user.logout'));

        $response->assertRedirect(route('user.home.index'));
        $this->assertGuest();
    }
}
