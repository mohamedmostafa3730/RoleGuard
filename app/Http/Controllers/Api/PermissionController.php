<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // GET /api/permissions
    public function index()
    {
        $permissions = Permission::all();
        return response()->json([
            'status' => 'success',
            'data' => $permissions
        ], Response::HTTP_OK); // 200
    }

    // POST /api/permissions
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);

        $permission = Permission::create(['name' => $request->name]);

        return response()->json([
            'message' => 'Permission created',
            'data' => $permission
        ], Response::HTTP_CREATED); // 201
    }

    // GET /api/permissions/{id}
    public function show(Permission $permission)
    {
        return response()->json($permission);
    }

    // PUT /api/permissions/{id}
    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|unique:permissions,name,' . $permission->id]);

        $permission->update(['name' => $request->name]);

        return response()->json(['message' => 'Updated successfully']);
    }

    // DELETE /api/permissions/{id}
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT); // 204
    }
}