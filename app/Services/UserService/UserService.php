<?php

namespace App\Services\UserService;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserService
{
    // Craete a new User function
    public function create(array $data, $request): User
    {
        return DB::transaction(function () use ($data, $request) {
            // hash the password before created user 
            $data['password'] = Hash::make($data['password']);
            // make email_verified_at verified now
            $data['email_verified_at'] = now();

            $user = User::create($data);

            // new user has array of rolles insert it into user
            if ($request->has('roles')) {
                $user->syncRoles($request->roles);
            }

            // if user upload avatar image add it to user
            if ($request->hasFile('avatar')) {
                $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
            }
            return $user->load('roles');
        });
    }
    // Update The User With ID
    public function update(User $user, array $data, $request)
    {
        return DB::transaction(function () use ($user, $data, $request) {

            // hash the password if the password is not empty and unset it if empty
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            // update the user model
            $user->update($data);

            // update the user roles
            if ($request->has('roles')) {
                $user->syncRoles($request->roles);
            }

            // update the user avatar
            if ($request->hasFile('avatar')) {
                $user->clearMediaCollection('avatar');
                $user->addMediaFromRequest('avatar')
                    ->toMediaCollection('avatar');
            }

            return $user;
        });

    }
    // Delete The user with ID
    public function delete(User $user)
    {
        return DB::transaction(function () use ($user) {
            $user->clearMediaCollection('avatar');
            $user->delete();
            return true;
        });
    }
}