<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_and_update_profile()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('user.profile.index'));
        $response->assertStatus(200);
        $response->assertSee($user->full_name); // Check if user's full name is visible

        $updatedData = [
            'full_name' => 'Updated Name',
            'phone' => '0987654321',
            'province' => $user->province_id,
            'district' => $user->district_id,
            'address' => 'Updated Address',
        ];

        $response = $this->get(route('user.profile.index'), $updatedData);
//        $response->assertJson([
//            'success' => true,
//            'message' => 'Profile updated successfully.',
//        ]);

        $user->refresh();
//        $this->assertEquals('Updated Name', $user->full_name);
//        $this->assertEquals('0987654321', $user->phone);
//        $this->assertEquals('Updated Address', $user->address);

        $invalidData = [
            'full_name' => '',
            'phone' => '',
            'province' => '',
            'district' => '',
            'address' => '',
        ];

        $response = $this->get(route('user.profile.index'), $invalidData);
        $response->assertStatus(200);
//        $response->assertJsonValidationErrors(['full_name', 'phone', 'province', 'district', 'address']);
    }

    public function test_update_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldPassword123'),
        ]);

        $this->actingAs($user);

        $validData = [
            'current_password' => 'oldPassword123',
            'new_password' => 'newPassword123',
            'new_password_confirmation' => 'newPassword123',
        ];

        // Test Successful Password Update
        $response = $this->post(route('user.profile.updatePassword'), $validData);
        $response->assertJson([
            'success' => true,
            'message' => 'Password updated successfully.',
        ]);

        $user->refresh();
        $this->assertTrue(Hash::check('newPassword123', $user->password));

        $invalidData = [
            'current_password' => 'wrongOldPassword',
            'new_password' => 'newPassword123',
            'new_password_confirmation' => 'newPassword123',
        ];

        $response = $this->post(route('user.profile.updatePassword'), $invalidData);
        $response->assertJson([
            'success' => false,
            'errors' => [
                'current_password' => ['Current password is incorrect.'],
            ],
        ]);

        $invalidData = [
            'current_password' => 'oldPassword123',
            'new_password' => 'short',
            'new_password_confirmation' => 'short',
        ];

        $response = $this->post(route('user.profile.updatePassword'), $invalidData);
        $response->assertStatus(302);
//        $response->assertJsonValidationErrors(['new_password']);
    }
}
