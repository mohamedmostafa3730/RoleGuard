<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\CreateUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService\UserService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected UserService $userService)
    {
    }

    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::with(['roles', 'permissions'])
            ->paginate(5)
            ->onEachSide(1);

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

        $this->authorize('create', User::class);

        $user = $this->userService->create(
            $request->validated(), // data
            $request // request
        );

        return $this->successResponse(
            new UserResource($user),
            'User created successfully',
            201
        );
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return $this->successResponse(
            new UserResource($user->load('roles')),
            'User retrieved successfully'
        );
    }

    public function update(UpdateUserRequest $request, User $user)
    {

        $this->authorize('update', $user);

        $updatedUser = $this->userService->update(
            $user,
            $request->validated(),
            $request,
        );

        return $this->successResponse(
            new UserResource($updatedUser->load('roles')),
            'User updated successfully'
        );
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        $this->userService->delete($user);
        
        return $this->successResponse(
            [],
            'User deleted successfully',
            200
        );
    }
}