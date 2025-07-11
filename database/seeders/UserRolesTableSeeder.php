<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                DB::table('user_roles')->insert([
            ['RoleName' => 'User', 'Description' => 'Standard user'],
            ['RoleName' => 'Admin', 'Description' => 'Administrator'],
        ]);
    }
}
