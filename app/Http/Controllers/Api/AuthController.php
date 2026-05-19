<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid credentials provided.', 401);
        }

        // Generate token (Using 'auth_token' as the identifier name)
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user->load(['roles', 'permissions'])),
        ], 'Authenticated successfully');
    }

    public function me()
    {
        return $this->successResponse(
            new UserResource(Auth::user()),
            'User fetched successfully',
            200
        );
    }

    public function logout(Request $request)
    {
        // Revoke the exact token used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'Logged out safely. Token revoked.');
    }


    public function refresh()
    {
        $user = Auth::user();

        // 1. Terminate current token
        $user->currentAccessToken()->delete();

        // 2. Issue a brand new one
        $newToken = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'access_token' => $newToken,
            'token_type' => 'Bearer',
        ], 'Token rotated successfully', 200);
    }
}