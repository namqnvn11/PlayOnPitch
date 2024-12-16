<?php

namespace Tests\Unit;

use App\Models\Boss;
use App\Models\Yard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class YardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Tạo dữ liệu District và Province
        $this->districtId = DB::table('districts')->insertGetId([
            'name' => 'Test District',
            'province_id' => 1, // Giả định ID province là 1
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->provinceId = DB::table('provinces')->insertGetId([
            'name' => 'Test Province',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tạo dữ liệu Boss
        $this->boss = Boss::factory()->create();

        // Dữ liệu mẫu cho sân bóng
        $this->yardData = [
            'yard_name' => 'Test Yard',
            'yard_type' => 'Type 1',
            'description' => 'Description of the yard',
            'district' => $this->districtId,
            'province' => $this->provinceId,
        ];

        // Đăng nhập với vai trò Boss
        Auth::guard('boss')->login($this->boss);
    }

    /** @test */
    public function it_can_create_a_yard()
    {
        $response = $this->actingAs($this->boss, 'boss')
            ->post(route('boss.yard.store'), $this->yardData);

        $response->assertStatus(302); // Chuyển hướng sau khi tạo thành công
        $response->assertRedirect(route('boss.yard.index')); // Kiểm tra URL
        $this->assertDatabaseHas('yards', [
            'yard_name' => 'Test Yard',
            'boss_id' => $this->boss->id,
        ]);
    }

    /** @test */
    public function it_can_block_a_yard()
    {
        $yard = Yard::factory()->create([
            'boss_id' => $this->boss->id,
            'block' => 0,
        ]);

        $response = $this->actingAs($this->boss, 'boss')
            ->patch(route('boss.yard.index', $yard->id));

        $response->assertStatus(200); // Thành công
        $this->assertDatabaseHas('yards', [
            'id' => $yard->id,
            'block' => 1,
        ]);
    }

    /** @test */
    public function it_can_unblock_a_yard()
    {
        $yard = Yard::factory()->create([
            'boss_id' => $this->boss->id,
            'block' => 1,
        ]);

        $response = $this->actingAs($this->boss, 'boss')
            ->patch(route('boss.yard.index', $yard->id));

        $response->assertStatus(200); // Thành công
        $this->assertDatabaseHas('yards', [
            'id' => $yard->id,
            'block' => 0,
        ]);
    }

    /** @test */
    public function it_can_search_a_yard_by_name()
    {
        Yard::factory()->create([
            'boss_id' => $this->boss->id,
            'yard_name' => 'Unique Yard Name',
        ]);

        $response = $this->actingAs($this->boss, 'boss')
            ->get(route('boss.yard.search', ['searchText' => 'Unique Yard']));

        $response->assertStatus(200);
        $response->assertSee('Unique Yard Name');
    }
}
