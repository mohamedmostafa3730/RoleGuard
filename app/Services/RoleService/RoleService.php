<?php

namespace App\Services\RoleService;

use App\Exceptions\ApiException;
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
            // user role cann't delete role with name admin
            if ($role->name == 'admin') {
                throw new ApiException('You can not delete admin role', 404);
            }
            // role cann't delete if user has this role
            if ($role->users()->count() > 0) {
                throw new ApiException('You can not delete role with users', 404);
            }

            // delete role
            return $role->delete();
        });
    }
}