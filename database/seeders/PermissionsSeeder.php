<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $resources = ['users', 'roles', 'permissions'];
        $actions = ['manage', 'view', 'create', 'edit', 'delete'];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$resource}-{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }
    }
}