<?php

use App\Http\Controllers\Contract\ContractController;
use App\Http\Controllers\Domain\StoreStatusController;
use App\Http\Controllers\Domain\StoreTypeController;
use App\Http\Controllers\Domain\TypeContractController;
use App\Http\Controllers\Permissions\RoleController as PermissionsRoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\People\PhysicalPersonController;
use App\Http\Controllers\People\LegalPersonController;
use App\Http\Controllers\Structure\PavementController;
use App\Http\Controllers\Structure\StoreController;
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

    Route::get('user/{user}/roles', [UserController::class, 'roles'])->name('user.roles');
    Route::put('user/{user}/roles/sync', [UserController::class, 'rolesSync'])->name('user.rolesSync');
    Route::resource('user', UserController::class);

    Route::resource('physicalPerson', PhysicalPersonController::class);
    Route::resource('legalPerson', LegalPersonController::class);
    Route::resource('pavement', PavementController::class);
    Route::resource('store', StoreController::class);

    Route::put('');
    Route::delete('contract/{contractRemoveStore}/removeStore', [ContractController::class, 'contractRemoveStore'])->name('contract.removeStore');
    Route::put('contract/signContract/{contract}', [ContractController::class, 'signContract'])->name('contract.singContract');
    Route::post('contract/contractStore/{contract}', [ContractController::class, 'contractStore'])->name('contract.contractStore');
    Route::resource('contract', ContractController::class);

    /**Domain */
    Route::prefix('domain')->group(function(){
        Route::resource('typeContract', TypeContractController::class);
        Route::resource('storeType', StoreTypeController::class);
        Route::resource('storeStatus', StoreStatusController::class);
    });

});

require __DIR__.'/auth.php';

