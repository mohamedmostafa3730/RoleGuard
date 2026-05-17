<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'users-manager',
            'roles-manager',
            'permissions-manager',
            'viewer',
            'editor',
            'creator',
            'deleter',
        ];

        foreach ($roles as $role) {
            $user = User::firstOrCreate(
                ['email' => $role . '@test.com'],
                [
                    'name' => str_replace('-', ' ', ucfirst($role)),
                    'password' => Hash::make('password'),
                ]
            );

            $user->syncRoles([$role]);
        }
    }
}