<?php

namespace Database\Seeders;

use App\Models\Boss;
use App\Models\Invoice;
use App\Models\PaymentTransaction;
use App\Models\Reservation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Voucher;
use App\Models\Yard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $list = [
//            [
//                'name' => 'Admin',
//                'email' => 'admin@admin.com',
//                'password' => Hash::make('password1234'),
//            ],
//        ];
//        DB::table('admins')->insert($list);
        Boss::factory(20)->create();
        Yard::factory(20)->create();
        Voucher::factory(20)->create();
        Reservation::factory(20)->create();
        Invoice::factory(20)->create();
        PaymentTransaction::factory(20)->create();
        User::factory(20)->create();
    }
}
