<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "taeyeon",
                "email" => "taeyeon@gmail.com",
                "password" => "12345678",
            ],
            [
                "name" => "yoona",
                "email" => "yoona@gmail.com",
                "password" => "12345678",
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->call(UsersTableSeeder::class);

        $factory = new UserFactory();
        $factory->count(10)->create();
    }

}
