<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\JsonResponse;

class RolesController extends Controller
{
    public function index(): JsonResponse
    {
        $roles = Role::with('permissions')->get();

        return response()->json([
            'data' => $roles,
            'message' => 'Roles retrieved successfully'
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
        ]);

        $role = Role::create(['name' => $validated['name']]);

        return response()->json([
            'message' => 'Role created successfully',
            'data' => $role
        ], 201);
    }

    public function show(Role $role): JsonResponse
    {
        $role->load('permissions');

        return response()->json([
            'data' => $role,
            'message' => 'Role details retrieved'
        ]);
    }

    public function update(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $validated['name']]);

        return response()->json([
            'message' => 'Role updated successfully',
            'data' => $role
        ]);
    }

    public function destroy(Role $role): JsonResponse
    {
        // Prevent deleting built-in roles if desired
        if (in_array($role->name, ['super-admin', 'admin', 'user'])) {
            return response()->json(['error' => 'Cannot delete protected role'], 403);
        }

        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }

    public function givePermissionToRole(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'permission' => 'required|string|exists:permissions,name',
        ]);

        $permission = Permission::where('name', $validated['permission'])->first();

        $role->givePermissionTo($permission);

        $role->load('permissions');

        return response()->json([
            'message' => 'Permission assigned to role',
            'data' => $role
        ]);
    }
}