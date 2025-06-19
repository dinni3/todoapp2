<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('role_permissions')->insert([
        ['RoleID' => 1, 'Description' => 'Create'],
        ['RoleID' => 1, 'Description' => 'Retrieve'],
        // etc.
        ['RoleID' => 2, 'Description' => 'Create'],
        ['RoleID' => 2, 'Description' => 'Delete'],
        ['RoleID' => 2, 'Description' => 'Activate'], // 2 = Admin
    ['RoleID' => 2, 'Description' => 'Deactivate'], // (optional, if you want separate permission)
        ['RoleID' => 2, 'Description' => 'Update'], // Admin can update
        ['RoleID' => 2, 'Description' => 'Retrieve'], // Admin can retrieve
        ['RoleID' => 2, 'Description' => 'View'], // Admin can view
        ['RoleID' => 2, 'Description' => 'Delete'], // Admin can delete
        // etc.
    ]);
    }
}
