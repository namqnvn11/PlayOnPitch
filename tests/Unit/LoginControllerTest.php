<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\Boss;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_login_with_valid_admin_credentials()
    {
        $admin = Admin::factory()->create([
//            'name' => 'John',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'
            )]);

        $response = $this->post(route('admin-boss.login'), [
//            'name' => 'John',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        // Kiểm tra chuyển hướng về trang quản lý admin
        $response->assertRedirect(route('admin.user.index'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    /** @test */
    public function test_login_with_valid_boss_credentials()
    {
        // Tạo dữ liệu Boss trong cơ sở dữ liệu
        $boss = Boss::factory()->create([
            'email' => 'boss@example.com',
            'password' => bcrypt('password'), // mật khẩu giả định
        ]);

        // Thực hiện đăng nhập
        $response = $this->post(route('admin-boss.login'), [
            'email' => 'boss@example.com',
            'password' => 'password',
        ]);

//        $response->assertRedirect(route('boss.yard.index'));
        $this->assertAuthenticatedAs($boss, 'boss');
    }

    /** @test */
    public function test_login_with_invalid_boss_credentials()
    {
        // Tạo dữ liệu Boss trong cơ sở dữ liệu
        $boss = Boss::factory()->create([
            'email' => 'boss@example.com',
            'password' => bcrypt('password'),
        ]);

        // Thực hiện đăng nhập với thông tin không chính xác
        $response = $this->post(route('admin-boss.login'), [
            'email' => 'boss@example.com',
            'password' => 'wrongpassword', // Sử dụng mật khẩu sai
        ]);

        // Kiểm tra xem có ở lại trang đăng nhập không
        $response->assertSessionHasErrors('email'); // Kiểm tra lỗi email (hoặc password tùy theo cách bạn cấu hình)
    }

    /** @test */
    public function test_login_with_blocked_boss_account()
    {
        $blockedBoss = Boss::factory()->create([
            'email' => 'blocked@example.com',
            'password' => bcrypt('password'),
            'block' => 1
        ]);

        $response = $this->post(route('admin-boss.login'), [
            'email' => 'blocked@example.com',
            'password' => 'password',
        ]);

        // Kiểm tra nếu có thông báo lỗi cho tài khoản bị khóa
        $response->assertSessionHasErrors(['email' => 'Your account has been blocked.']);
        $this->assertGuest();
    }

    /** @test */
    public function test_login_with_valid_user_credentials()
    {
        // Tạo dữ liệu User trong cơ sở dữ liệu
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        // Thực hiện đăng nhập
        $response = $this->post(route('login'), [
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('user.home.index'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_login_with_invalid_user_credentials()
    {
        // Tạo dữ liệu User trong cơ sở dữ liệu
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        // Thực hiện đăng nhập với thông tin không chính xác
        $response = $this->post(route('login'), [
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        // Kiểm tra xem có ở lại trang đăng nhập không
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function test_login_with_blocked_user_account()
    {
        // Tạo một User bị khóa
        $blockedUser = User::factory()->create([
            'email' => 'blocked@example.com',
            'password' => bcrypt('password'),
            'block' => 1, // Giả sử bạn có cột blocked trong database để đánh dấu tài khoản bị khóa
        ]);

        // Thực hiện đăng nhập
        $response = $this->post(route('login'), [
            'email' => 'blocked@example.com',
            'password' => 'password',
        ]);

        // Kiểm tra thông báo lỗi nếu tài khoản bị khóa
        $response->assertSessionHasErrors(['email' => 'Your account has been blocked.']);
        $this->assertGuest(); // Kiểm tra xem người dùng có phải là khách không
    }
}
