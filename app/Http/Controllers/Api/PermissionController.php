<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\permission\CreatePermissionRequest;
use App\Http\Requests\permission\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Permission::class);

        $permissions = Permission::with('roles')->paginate(3)->onEachSide(1);

        return $this->successResponse([
            'permissions' => PermissionResource::collection($permissions),
            'pagination' => [
                'total' => $permissions->total(),
                'current_page' => $permissions->currentPage(),
                'per_page' => $permissions->perPage(),
                'last_page' => $permissions->lastPage(),
            ]
        ], 'permissions retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePermissionRequest $request)
    {
        $this->authorize('create', Permission::class);

        $permission = Permission::create($request->validated());

        return $this->successResponse(
            new PermissionResource($permission),
            'Permission created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $this->authorize('view', $permission);

        return $this->successResponse(
            new PermissionResource($permission),
            'permission retrieved successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {

        $this->authorize('update', $permission);

        $permission->update($request->validated());

        return $this->successResponse(
            new PermissionResource(
                $permission
            ),
            'Permission updated successfully.',
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);

        $permission->delete();

        return $this->successResponse(
            [],
            'Permission deleted successfully'
        );
    }
}