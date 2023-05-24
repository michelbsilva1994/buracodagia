<?php

use App\Http\Controllers\Permissions\RoleController as PermissionsRoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\People\PhysicalPersonController;
use App\Http\Controllers\People\LegalPersonController;
use App\Http\Controllers\Structure\PavementController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

    Route::get('role/{role}/permissions',[RoleController::class,'permissions'])->name('role.permission');
    Route::put('role/{role}/permissions/sync', [RoleController::class,'permissionsSync'])->name('role.permissionsSync');
    Route::resource('role', RoleController::class);

    Route::resource('permission', PermissionController::class);

    Route::resource('user', UserController::class);

    Route::resource('physicalPerson', PhysicalPersonController::class);
    Route::resource('legalPerson', LegalPersonController::class);
    ROute::resource('pavement', PavementController::class);
});

require __DIR__.'/auth.php';
