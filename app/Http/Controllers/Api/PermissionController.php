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
        $currentUser = $request->user();

        if (!$currentUser->hasAnyRole(['admin', 'permissions-manager', 'creator'])) {
            return $this->errorResponse(
                'Access Denied. You do not have permission to create users.',
                403
            );
        }

        $data = $request->validated();

        $permission = Permission::create($data);

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

        if (!$permission) {
            return $this->errorResponse('User not found', 404);
        }

        // => NOT WORK  
        // if ($permission->guard_name === "web") {
        //     return $this->errorResponse('There is no ', 404);
        // }

        return $this->successResponse(
            new PermissionResource($permission),
            'Permission created successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $currentUser = $request->user();

        if (!$currentUser->hasAnyRole(['admin', 'permissions-manager', 'editor'])) {
            return $this->errorResponse(
                'Access Denied. You do not have permission to create users.',
                403
            );
        }

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
    public function destroy(Request $request, Permission $permission)
    {
        $currentUser = $request->user();

        if (!$currentUser->hasAnyRole(['admin', 'permissions-manager', 'deleter'])) {
            return $this->errorResponse(
                'Access Denied. You do not have permission to create users.',
                403
            );
        }

        $permission->delete();

        return $this->successResponse(
            [],
            'Permission deleted successfully'
        );
    }
}