<?php

namespace Database\Seeders;

use App\Models\Boss;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Voucher;
use App\Models\Yard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function Sodium\add;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Voucher::Create([
            'id'=>'9999',
            'name'=>'Tặng 100.000 cho lần đăng ký đầu tiên',
            'price'=>100000,
            'release_date'=>now(),
            'end_date'=>now()->addYear(50),
            'conditions_apply'=>0,
            'block'=>0
        ]);
    }
}
