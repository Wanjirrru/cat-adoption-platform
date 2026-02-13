<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\JsonResponse;

class PermissionsController extends Controller
{
    public function index(): JsonResponse
    {
        $permissions = Permission::all();

        return response()->json([
            'data' => $permissions,
            'message' => 'Permissions retrieved'
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name|max:255',
        ]);

        $permission = Permission::create(['name' => $validated['name']]);

        return response()->json([
            'message' => 'Permission created',
            'data' => $permission
        ], 201);
    }

    public function show(Permission $permission): JsonResponse
    {
        return response()->json([
            'data' => $permission,
            'message' => 'Permission details'
        ]);
    }

    public function update(Request $request, Permission $permission): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $validated['name']]);

        return response()->json([
            'message' => 'Permission updated',
            'data' => $permission
        ]);
    }

    public function destroy(Permission $permission): JsonResponse
    {
        $permission->delete();

        return response()->json(['message' => 'Permission deleted']);
    }
}