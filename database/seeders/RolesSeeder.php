<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // ensure permissions exist
        $permissions = Permission::all();

        /*
        |----------------------------
        | ADMIN (FULL ACCESS)
        |----------------------------
        */
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $admin->syncPermissions($permissions);

        /*
        |----------------------------
        | MANAGERS (module-based)
        |----------------------------
        */

        $rolesManager = Role::firstOrCreate([
            'name' => 'roles-manager',
            'guard_name' => 'web',
        ]);
        $rolesManager->syncPermissions(
            Permission::where('name', 'like', 'roles-%')->get()
        );

        $usersManager = Role::firstOrCreate([
            'name' => 'users-manager',
            'guard_name' => 'web',
        ]);
        $usersManager->syncPermissions(
            Permission::where('name', 'like', 'users-%')->get()
        );

        $permissionsManager = Role::firstOrCreate([
            'name' => 'permissions-manager',
            'guard_name' => 'web',
        ]);
        $permissionsManager->syncPermissions(
            Permission::where('name', 'like', 'permissions-%')->get()
        );

        /*
        |----------------------------
        | CRUD ROLES
        |----------------------------
        */

        Role::firstOrCreate([
            'name' => 'creator',
            'guard_name' => 'web',
        ])->syncPermissions(
            Permission::whereIn('name', [
                'users-create',
                'roles-create',
                'permissions-create',
            ])->get()
        );

        Role::firstOrCreate([
            'name' => 'viewer',
            'guard_name' => 'web',
        ])->syncPermissions(
            Permission::whereIn('name', [
                'users-view',
                'roles-view',
                'permissions-view',
            ])->get()
        );

        Role::firstOrCreate([
            'name' => 'editor',
            'guard_name' => 'web',
        ])->syncPermissions(
            Permission::whereIn('name', [
                'users-edit',
                'roles-edit',
                'permissions-edit',
            ])->get()
        );

        Role::firstOrCreate([
            'name' => 'deleter',
            'guard_name' => 'web',
        ])->syncPermissions(
            Permission::whereIn('name', [
                'users-delete',
                'roles-delete',
                'permissions-delete',
            ])->get()
        );
    }
}