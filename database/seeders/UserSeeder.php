<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        $users = [
            [
                "name" => "Admin",
                "email" => "admin@shiprocket.com",
                "email_verified_at" => now()->format(TIMESTAMP_STANDARD),
                "password" => Hash::make("admin"),
                "last_active" => now()->format(TIMESTAMP_STANDARD)
            ]
        ];

        foreach ($users as $user)
        {
            User::query()->create($user);
        }
    }
}
