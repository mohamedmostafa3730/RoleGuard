<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\role\CreateRoleRequest;
use App\Http\Requests\role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService\RoleService;
use App\Traits\ApiResponseTrait;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */

    public function __construct(
        private RoleService $roleService
    ) {
    }

    public function index()
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::paginate(5)->onEachSide(1);

        return $this->successResponse([
            'permissions' => RoleResource::collection($roles),
            'pagination' => [
                'total' => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page' => $roles->perPage(),
                'last_page' => $roles->lastPage(),
            ]
        ], 'Roles retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $data = $request->validated();


        $createdData = $this->roleService->create(
            $data,
            $request
        );

        return $this->successResponse(
            new RoleResource($createdData),
            'role is created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {

        $this->authorize('view', $role);

        return $this->successResponse(
            new RoleResource($role),
            'Role retrieved successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        $role = $this->roleService->update(
            $role,
            $request->validated(),
            $request
        );

        return $this->successResponse(
            new RoleResource($role),
            'Role updated successfully.',
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        $this->roleService->delete($role);

        return $this->successResponse(
            [],
            'Role deleted successfully',
            200
        );
    }
}