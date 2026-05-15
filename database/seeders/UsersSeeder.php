<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a User has admin role
        $userHasAdminRole = User::createOrFirst([
            "name" => fake()->name,
            "email" => fake()->unique()->email,
            "password" => Hash::make("admin123456"),
        ]);
        $userHasAdminRole->assignRole('admin');
        // 2. Create a User has users-manage role
        $userHasAdminRole = User::createOrFirst([
            "name" => fake()->name,
            "email" => fake()->unique()->email,
            "password" => Hash::make("admin123456"),
        ]);
        $userHasAdminRole->assignRole('user-manager');
        // 3. Create a User has roles-manage role
        $userHasAdminRole = User::createOrFirst([
            "name" => fake()->name,
            "email" => fake()->unique()->email,
            "password" => Hash::make("admin123456"),
        ]);
        $userHasAdminRole->assignRole('role-manager');
        // 4. Create a User has permissions-manage role
        $userHasAdminRole = User::createOrFirst([
            "name" => fake()->name,
            "email" => fake()->unique()->email,
            "password" => Hash::make("admin123456"),
        ]);
        $userHasAdminRole->assignRole('permissions-manager');
        // 5. Create a User has viewer role 
        $userHasAdminRole = User::createOrFirst([
            "name" => fake()->name,
            "email" => fake()->unique()->email,
            "password" => Hash::make("admin123456"),
        ]);
        $userHasAdminRole->assignRole('viewer');
        // 6. Create a User has editor role
        $userHasAdminRole = User::createOrFirst([
            "name" => fake()->name,
            "email" => fake()->unique()->email,
            "password" => Hash::make("admin123456"),
        ]);
        $userHasAdminRole->assignRole('editor');
        // 7. Create a User has creator role
        $userHasAdminRole = User::createOrFirst([
            "name" => fake()->name,
            "email" => fake()->unique()->email,
            "password" => Hash::make("admin123456"),
        ]);
        $userHasAdminRole->assignRole('creator');
        // 8. Create a User has deleter role 
        $userHasAdminRole = User::createOrFirst([
            "name" => fake()->name,
            "email" => fake()->unique()->email,
            "password" => Hash::make("admin123456"),
        ]);
        $userHasAdminRole->assignRole('deleter');

    }
}
