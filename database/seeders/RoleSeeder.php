<?php

namespace Database\Seeders;

use App\Models\Models\Role;
use App\Models\Models\UserRole;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        $roles = [
            ["name" => "SuperAdmin", "key" => "super-admin"],
            ["name" => "Admin", "key" => "admin"],
            ["name" => "KAM", "key" => "kam"],
            ["name" => "CS", "key" => "cs"],
        ];

        foreach ($roles as $role)
        {
            Role::query()->create($role);
        }

        UserRole::query()->create([
            "role_id" => 1,
            "user_id" => 1
        ]);
    }
}
