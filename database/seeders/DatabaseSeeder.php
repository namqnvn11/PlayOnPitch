<?php

namespace Database\Seeders;

use App\Models\Boss;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $list = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password1234'),
            ],
        ];

        DB::table('admins')->insert($list);
        User::factory()->count(10)->create();
        Boss::factory()->count(10)->create();


    }
}
