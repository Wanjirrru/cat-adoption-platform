<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::with('roles')->latest()->get();

        return response()->json([
            'data' => $users,
            'message' => 'Users retrieved'
        ]);
    }

    public function show(User $user): JsonResponse
    {
        $user->load('roles');

        return response()->json([
            'data' => $user,
            'message' => 'User details retrieved'
        ]);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $data = array_filter([
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
        ]);

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        $user->load('roles');

        return response()->json([
            'message' => 'User updated',
            'data' => $user
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        if ($user->hasRole('super-admin')) {
            return response()->json(['error' => 'Cannot delete super-admin'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}