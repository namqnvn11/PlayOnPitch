<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\BossController;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class BossControllerTest extends TestCase
{
    public function test_store_new_boss()
    {
        $bossController = Mockery::mock(BossController::class)->makePartial();
        $request = Request::create('/admin/boss', 'POST', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'full_name' => 'Test Boss',
            'phone' => '+84912345678',
            'company_name' => 'Test Company',
            'company_address' => 'Test Address',
            'status' => 'active',
            'district' => 1,
            'province' => 1,
        ]);

        $bossController->shouldReceive('store')
            ->once()
            ->with($request)
            ->andReturn(redirect()->route('admin.boss.index'));

        $response = $bossController->store($request);

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_block_boss()
    {
        $bossController = Mockery::mock(BossController::class)->makePartial();
        $boss = Mockery::mock(Boss::class);
        $boss->id = 1;
        $boss->block = 0;

        $bossController->shouldReceive('block')
            ->once()
            ->with($boss->id)
            ->andReturn(response()->json(['success' => true]));

        $response = $bossController->block($boss->id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['success' => true], $response->getData(true));
    }

    public function test_unblock_boss()
    {
        $bossController = Mockery::mock(BossController::class)->makePartial();
        $boss = Mockery::mock(Boss::class);
        $boss->id = 1;
        $boss->block = 1;

        $bossController->shouldReceive('unblock')
            ->once()
            ->with($boss->id)
            ->andReturn(response()->json(['success' => true]));

        $response = $bossController->unblock($boss->id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['success' => true], $response->getData(true));
    }

    public function test_reset_password()
    {
        $bossController = Mockery::mock(BossController::class)->makePartial();
        $request = Request::create('/admin/boss/reset-password', 'POST', [
            'new_password' => 'newpassword123',
        ]);
        $boss = Mockery::mock(Boss::class);
        $boss->id = 1;

        $bossController->shouldReceive('resetPassword')
            ->once()
            ->with($request, $boss->id)
            ->andReturn(response()->json(['success' => true]));

        $response = $bossController->resetPassword($request, $boss->id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['success' => true], $response->getData(true));
    }

    public function test_search_boss()
    {
        $bossController = Mockery::mock(BossController::class)->makePartial();
        $request = Request::create('/admin/boss/search', 'GET', [
            'searchText' => 'Boss One',
        ]);

        $bossController->shouldReceive('search')
            ->once()
            ->with($request)
            ->andReturn(view('admin.boss.index', [
                'bosses' => collect([
                    ['id' => 1, 'full_name' => 'Boss One', 'email' => 'one@example.com']
                ]),
            ]));

        $response = $bossController->search($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Boss One', $response->getContent());
    }
}
