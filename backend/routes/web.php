<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CatsController;
use App\Http\Controllers\AdoptionsController;
use App\Http\Controllers\PaymentsController;


Route::group(['middleware' => 'auth'], function () {

Route::resource('permissions', App\Http\Controllers\PermissionController::class);
Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class,'destroy']);

Route::resource('roles', App\Http\Controllers\RoleController::class);
Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class,'destroy']);
Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

Route::resource('users', App\Http\Controllers\UserController::class);
Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);

});

Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::resource('cats', CatsController::class);
Route::get('/cats', [CatsController::class, 'index'])->name('cats.index');
Route::get('/cats/{cat}/edit', [CatsController::class, 'edit'])->name('cats.edit');
Route::delete('/cats/{cat}', [CatsController::class, 'destroy'])->name('cats.destroy');

Route::get('/adoptions', [AdoptionsController::class, 'index'])->name('adoptions.index');
// Route::put('/adoptions', [AdoptionsController::class, 'store'])->name('adoptions.store');
Route::delete('adoptions/{adoptionId}/delete', [AdoptionsController::class,'destroy']);
Route::get('adoptions/create/{catId}', [AdoptionsController::class,'create'])->name('adoptions.create');
Route::put('adoptions/store/{catId}', [AdoptionsController::class, 'store'])->name('adoptions.store.cat');

Route::patch('/adoptions/{adoption}', [AdoptionsController::class, 'update'])->name('adoptions.update');
Route::patch('/adoptions/{adoptionId}/approve', [AdoptionsController::class, 'approve'])->name('adoptions.approve');
Route::patch('/adoptions/{adoptionId}/deny', [AdoptionsController::class, 'deny'])->name('adoptions.deny');

Route::get('/adoptions/{adoption}/payment', [AdoptionsController::class, 'payment'])->name('adoptions.payment');
Route::post('/adoptions/{adoption}/process-payment', [AdoptionsController::class, 'processPayment'])->name('adoptions.processPayment');




Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';