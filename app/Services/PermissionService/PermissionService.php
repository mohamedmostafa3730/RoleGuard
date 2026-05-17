<?php

namespace App\Services\PermissionService;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    public function create(array $data): Permission
    {
        return DB::transaction(function () use ($data) {
            return Permission::create($data);
        });
    }

    public function update(Permission $permission, array $data): Permission
    {
        return DB::transaction(function () use ($permission, $data) {
            $permission->update($data);
            return $permission;
        });
    }

    public function delete(Permission $permission): Permission
    {
        return DB::transaction(function () use ($permission) {
            return $permission->delete();
        });
    }
}