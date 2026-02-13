<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatsController;
use App\Http\Controllers\Api\AdoptionsController;
use App\Http\Controllers\Api\PaymentsController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\PermissionsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\DashboardController;

Route::post('/register', [AuthController::class, 'register']);
// routes/api.php
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (! Auth::attempt($credentials)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $user = Auth::user();

    if (config('sanctum.stateful_auth', false)) {
        // Cookie-based (stateful)
        Auth::login($user);
        $request->session()->regenerate();
        return response()->json([
            'message' => 'Login successful (cookie-based)',
            'user' => $user,
        ]);
    }

    // Token-based (your current default)
    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful (token-based)',
        'user' => $user,
        'token' => $token,
    ]);
});
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
    $user = $request->user()->load('roles'); // loads the roles relationship

    return response()->json([
        'id'    => $user->id,
        'name'  => $user->name,
        'email' => $user->email,
        'roles' => $user->roles->pluck('name')->toArray(), // just the role names
        // optional: add more fields if needed
        // 'created_at' => $user->created_at,
    ]);
   });
    // Public cat browsing
    Route::get('/cats', [CatsController::class, 'index']);
    Route::get('/cats/{cat}', [CatsController::class, 'show']);

    // Protected routes
    Route::apiResource('cats', CatsController::class)->except(['index', 'show']);

    Route::get('/adoptions', [AdoptionsController::class, 'index']);
    Route::post('/adoptions/create/{cat}', [AdoptionsController::class, 'store']);
    Route::patch('/adoptions/{adoption}/approve', [AdoptionsController::class, 'approve']);
    Route::patch('/adoptions/{adoption}/deny',    [AdoptionsController::class, 'deny']);
    Route::get('/adoptions/{adoption}/payment',   [AdoptionsController::class, 'payment']);
    Route::post('/adoptions/{adoption}/process-payment', [AdoptionsController::class, 'processPayment']);

    // Admin-only (Spatie)
    Route::middleware('role:admin|super-admin')->group(function () {
        Route::apiResource('roles', RolesController::class);
        Route::apiResource('permissions', PermissionsController::class);
        Route::apiResource('users', UsersController::class);

        Route::post('roles/{role}/give-permissions', [RolesController::class, 'givePermissionToRole']);
    });

    // Dashboard stats
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
});

Route::post('/payments/callback', [PaymentsController::class, 'handleCallback']); // M-PESA webhook (public)