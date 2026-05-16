<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\CreateUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $users = User::with(['roles', 'permissions'])->paginate(5);

        return $this->successResponse([
            'users' => UserResource::collection($users),
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage(),
            ]
        ], 'Users retrieved successfully', 200);
    }

    public function store(CreateUserRequest $request)
    {
        $currentUser = $request->user();

        if (!$currentUser->hasAnyRole(['admin', 'creator', 'user-manager'])) {
            return $this->errorResponse(
                'Access Denied. You do not have permission to create users.',
                403
            );
        }

        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $data['email_verified_at'] = now();

        $user = User::create($data);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }


        return $this->successResponse(
            new UserResource($user->load('roles')),
            'User created successfully',
            201
        );
    }

    public function show(string $id)
    {
        $user = User::with(['roles', 'permissions'])->find($id);

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        return $this->successResponse(
            new UserResource($user),
            'User retrieved successfully'
        );
    }

    public function update(UpdateUserRequest $request, User $user)
    {

        $currentUser = $request->user();

        if (!$currentUser->hasAnyRole(['admin', 'editor', 'user-manager'])) {
            return $this->errorResponse(
                'Access Denied. You do not have permission to update users.' . $currentUser->roles->pluck('name'),
                403
            );
        }

        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        return $this->successResponse(
            new UserResource($user->load('roles')),
            'User updated successfully'
        );
    }

    public function destroy(Request $request, User $user)
    {

        $currentUser = $request->user();

        if (!$currentUser->hasAnyRole(['admin', 'deleter', 'user-manager'])) {
            return $this->errorResponse(
                'Access Denied. You do not have permission to delete users.',
                403
            );
        }

        $user->clearMediaCollection('avatars');
        $user->delete();

        return $this->successResponse(
            [],
            'User deleted successfully'
        );
    }
}