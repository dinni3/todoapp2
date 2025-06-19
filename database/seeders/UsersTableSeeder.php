<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                "name" => "user1",
                "email" => "user1@gmail.com",
                "password" => bcrypt("abcd1234"),
                "RoleID" => 1,
            ],
            [
                "name" => "user2",
                "email" => "user2@gmail.com",
                "password" => bcrypt("abcd1234"),
                "RoleID" => 2,
            ],
            [
                "name" => "dinnie",
                "email" => "dinniehaiqall@gmail.com",
                "password" => bcrypt("abcd1234"),
                "RoleID" => 1,
            ],
        ];
    
        foreach ($users as $userData) {
            User::create($userData);
        }

    }

    
}
