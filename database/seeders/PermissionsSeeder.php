<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // only manage
            'users-manage',
            'roles-manage',
            'permissions-manage',
            // only view
            'users-viewer',
            'roles-viewer',
            'permissions-viewer',
            // only create
            'users-creator',
            'roles-creator',
            'permissions-creator',
            // only delete
            'users-deleter',
            'roles-deleter',
            'permissions-deleter',
            // only update
            'users-editor',
            'roles-editor',
            'permissions-editor',
        ];

        foreach ($permissions as $permission) {
            Permission::createOrFirst(['name' => $permission]);
        }
    }
}