<?php

namespace App\Services\RoleService;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleService
{
    // craete a new role
    public function create(array $data, $request): Role
    {
        return DB::transaction(function () use ($data, $request) {
            return Role::create($data);
        });

    }
    // update a role
    public function update(Role $role, array $data, $request): Role
    {
        return DB::transaction(function () use ($role, $data, $request) {
            return $role->update($data);
        });

    }
    // delete a role
    public function delete(Role $role): bool
    {
        return DB::transaction(function () use ($role) {
            return $role->delete();
        });
    }
}