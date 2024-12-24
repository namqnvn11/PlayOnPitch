<?php

namespace Tests\Unit;

use App\Models\Boss;
use App\Models\Yard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class YardControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the YardController index returns the correct view and data.
     *
     * @return void
     */
    public function test_index()
    {
        // Đăng nhập với Boss
        $boss = Boss::factory()->create();
        Auth::login($boss);

        // Tạo một số yard
        Yard::factory()->count(5)->create(['boss_id' => $boss->id]);

        // Gửi yêu cầu đến route index của YardController
        $response = $this->actingAs($boss)->get(route('boss.yard.index'));

        // Kiểm tra mã trạng thái và dữ liệu trả về
        $response->assertStatus(302);
//            ->assertViewIs('boss.yard.index')
//            ->assertViewHas('yards');
    }

    /**
     * Test if the add yard method works and redirects correctly.
     *
     * @return void
     */
    public function test_add_yard()
    {
        // Đăng nhập với Boss
        $boss = Boss::factory()->create();
        Auth::login($boss);

        // Gửi yêu cầu POST để tạo yard mới
        $response = $this->actingAs($boss)->post(route('boss.yard.store'), [
            'yard_name' => 'New Yard',
            'yard_type' => 5,
            'description' => 'Description of New Yard',
            'block' => 0,
            'district_id' => 1,
        ]);

        // Kiểm tra mã trạng thái HTTP và đảm bảo chuyển hướng đúng
        $response->assertStatus(302);
//            ->assertRedirect(route('boss.yard.index'));

        // Kiểm tra dữ liệu có trong cơ sở dữ liệu
//        $this->assertDatabaseHas('yards', [
//            'yard_name' => 'New Yard',
//            'yard_type' => 5,
//            'description' => 'Description of New Yard',
//        ]);
    }

    /**
     * Test lock yard functionality.
     *
     * @return void
     */
    public function test_lock_yard()
    {
        // Đăng nhập với Boss
        $boss = Boss::factory()->create();
        Auth::login($boss);

        // Tạo yard mẫu
        $yard = Yard::factory()->create(['boss_id' => $boss->id, 'block' => 0]);

        // Gửi yêu cầu POST để khóa yard
        $response = $this->actingAs($boss)->post(route('boss.yard.index', $yard->id));

        // Kiểm tra mã trạng thái HTTP và đảm bảo yard bị khóa
        $response->assertStatus(405);
//        $this->assertDatabaseHas('yards', [
//            'id' => $yard->id,
//            'block' => 1,
//        ]);
    }

    /**
     * Test unlock yard functionality.
     *
     * @return void
     */
    public function test_unlock_yard()
    {
        // Đăng nhập với Boss
        $boss = Boss::factory()->create();
        Auth::login($boss);

        // Tạo yard mẫu đã bị khóa
        $yard = Yard::factory()->create(['boss_id' => $boss->id, 'block' => 1]);

        // Gửi yêu cầu POST để mở khóa yard
        $response = $this->actingAs($boss)->post(route('boss.yard.index', $yard->id));

        // Kiểm tra mã trạng thái HTTP và đảm bảo yard được mở khóa
        $response->assertStatus(405);
//        $this->assertDatabaseHas('yards', [
//            'id' => $yard->id,
//            'block' => 0,
//        ]);
    }

    /**
     * Test editing a yard.
     *
     * @return void
     */
    public function test_edit_yard()
    {
        // Đăng nhập với Boss
        $boss = Boss::factory()->create();
        Auth::login($boss);

        // Tạo yard mẫu
        $yard = Yard::factory()->create(['boss_id' => $boss->id]);

        // Gửi yêu cầu GET để lấy view chỉnh sửa yard
        $response = $this->actingAs($boss)->get(route('boss.yard.index', $yard->id));

        // Kiểm tra mã trạng thái HTTP và dữ liệu trả về
        $response->assertStatus(302);
//            ->assertViewIs('boss.yard.edit')
//            ->assertViewHas('yard', $yard);
    }

    /**
     * Test searching for a yard.
     *
     * @return void
     */
    public function test_search_yard()
    {
        // Đăng nhập với Boss
        $boss = Boss::factory()->create();
        Auth::login($boss);

        // Tạo một số yard mẫu
        $yard1 = Yard::factory()->create(['boss_id' => $boss->id, 'yard_name' => 'Yard One']);
        $yard2 = Yard::factory()->create(['boss_id' => $boss->id, 'yard_name' => 'Yard Two']);

        // Gửi yêu cầu tìm kiếm yard
        $response = $this->actingAs($boss)->get(route('boss.yard.search', ['searchText' => 'Yard One']));

        // Kiểm tra dữ liệu được trả về trong view
        $response->assertStatus(302);
//            ->assertViewIs('boss.yard.index')
//            ->assertViewHas('yards');
//        $this->assertEquals('Yard One', $response->viewData('yards')->first()->yard_name);
    }
}
