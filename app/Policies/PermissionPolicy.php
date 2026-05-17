<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canAny(['permissions-manage', 'permissions-view']);
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->canAny(['permissions-manage', 'permissions-view']);
    }

    public function create(User $user): bool
    {
        return $user->can('permissions-manage') || $user->can('permissions-create');
    }

    public function update(User $user, Permission $permission): bool
    {
        return $user->can('permissions-manage') || $user->can('permissions-edit');
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->can('permissions-manage') || $user->can('permissions-delete');
    }

    public function restore(User $user, Permission $permission): bool
    {
        return $user->can('permissions-manage');
    }

    public function forceDelete(User $user, Permission $permission): bool
    {
        return $user->can('permissions-manage');
    }
}
