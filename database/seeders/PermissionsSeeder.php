<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Create Permissions
        $permissions = [
            'users-manage',
            'roles-manage',
            'permissions-manage',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 3. Create Admin Role and assign all permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 4. Create a Standard admin Role for manage only users-manage permission
        $admin2 = Role::create(['name' => 'user-manager']);
        $admin2->givePermissionTo('users-manage');

        // 5. Create a Standard admin Role for manage only roles-manage permission
        $admin3 = Role::create(['name' => 'role-manager']);
        $admin3->givePermissionTo('roles-manage');

        // 6. Create a Standard admin Role for manage only permissions-manage permission
        $admin4 = Role::create(['name' => 'permission-manager']);
        $admin4->givePermissionTo('permissions-manage');

        // 7. Create the Super Admin User
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'), // Always hash passwords!
        ]);
        $admin->assignRole($adminRole);

        // 8. Create a Regular Test User
        $userManager = User::create([
            'name' => 'user-manager',
            'email' => 'user-manager@test.com',
            'password' => Hash::make('password'),
        ]);
        $userManager->assignRole($admin2);

        // 9. Create a Regular Test User
        $roleManager = User::create([
            'name' => 'role-manager',
            'email' => 'role-manager@test.com',
            'password' => Hash::make('password'),
        ]);
        $roleManager->assignRole($admin3);
        
        // 10. Create a Regular Test User
        $permissionManager = User::create([
            'name' => 'permission-manager',
            'email' => 'permission-manager@test.com',
            'password' => Hash::make('password'),
        ]);
        $permissionManager->assignRole($admin4);
    }
}