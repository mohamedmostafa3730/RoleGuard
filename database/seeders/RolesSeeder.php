<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin Role and assign all permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 2. Create a Standard admin Role for manage only users-manage permission
        $admin2 = Role::create(['name' => 'user-manager']);
        $admin2->givePermissionTo('users-manage');

        // 3. Create a Standard admin Role for manage only roles-manage permission
        $admin3 = Role::create(['name' => 'role-manager']);
        $admin3->givePermissionTo('roles-manage');

        // 4. Create a Standard admin Role for manage only permissions-manage permission
        $admin4 = Role::create(['name' => 'permissions-manager']);
        $admin4->givePermissionTo('permissions-manage');

        // 5. Create a Standard admin Role for create only all data [users,roles,permissions]
        $admin5 = Role::create(['name' => 'creator']);
        $admin5->givePermissionTo('users-creator');
        $admin5->givePermissionTo('roles-creator');
        $admin5->givePermissionTo('permissions-creator');

        // 6. Create a Standard admin Role for show only all data [users,roles,permissions]
        $admin6 = Role::create(['name' => 'viewer']);
        $admin6->givePermissionTo('users-viewer');
        $admin6->givePermissionTo('roles-viewer');
        $admin6->givePermissionTo('permissions-viewer');

        // 7. Create a Standard admin Role for update only all data [users,roles,permissions]
        $admin7 = Role::create(['name' => 'editor']);
        $admin7->givePermissionTo('users-editor');
        $admin7->givePermissionTo('roles-editor');
        $admin7->givePermissionTo('permissions-editor');

        // 8. Create a Standard admin Role for delete only all data  [users,roles,permissions]
        $admin8 = Role::create(['name' => 'deleter']);
        $admin8->givePermissionTo('users-deleter');
        $admin8->givePermissionTo('roles-deleter');
        $admin8->givePermissionTo('permissions-deleter');
    }
}
