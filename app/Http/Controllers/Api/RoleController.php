<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\role\CreateRoleRequest;
use App\Http\Requests\role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
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

        $createdData = Role::create($data);

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

        $role->update($request->validated());

        return $this->successResponse(
            new RoleResource(
                $role
            ),
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

        $role->delete();

        return $this->successResponse(
            [],
            'Permission deleted successfully'
        );
    }
}