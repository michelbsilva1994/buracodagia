<?php

use App\Http\Controllers\Contract\ContractController;
use App\Http\Controllers\Domain\StoreStatusController;
use App\Http\Controllers\Domain\StoreTypeController;
use App\Http\Controllers\Domain\TypeContractController;
use App\Http\Controllers\MonthlyPaymentController;
use App\Http\Controllers\Permissions\RoleController as PermissionsRoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\People\PhysicalPersonController;
use App\Http\Controllers\People\LegalPersonController;
use App\Http\Controllers\Services\HomeServiceDomainController;
use App\Http\Controllers\Services\HomeServicesController;
use App\Http\Controllers\Services\HomeServiceSecurityController;
use App\Http\Controllers\Structure\PavementController;
use App\Http\Controllers\Structure\StoreController;
use App\Models\Contract\MonthlyPayment;
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
    /**rota filtrar pessoal fisica */
    Route::post('physicalPerson/filter', [PhysicalPersonController::class, 'filter'])->name('physical.filter');
    Route::get('contractPerson/{id_person}', [PhysicalPersonController::class, 'contractPerson'])->name('physical.contractPerson');

    Route::resource('legalPerson', LegalPersonController::class);
    Route::resource('pavement', PavementController::class);
    Route::resource('store', StoreController::class);

    Route::delete('contract/{contractRemoveStore}/removeStore', [ContractController::class, 'contractRemoveStore'])->name('contract.removeStore');
    Route::put('contract/signContract/{contract}', [ContractController::class, 'signContract'])->name('contract.singContract');
    Route::post('contract/contractStore/{contract}', [ContractController::class, 'contractStore'])->name('contract.contractStore');
    Route::resource('contract', ContractController::class);

    /**Generate Tuition */
    Route::resource('monthly', MonthlyPaymentController::class);


    /**Domain */
    Route::prefix('domain')->group(function(){
        Route::resource('typeContract', TypeContractController::class);
        Route::resource('storeType', StoreTypeController::class);
        Route::resource('storeStatus', StoreStatusController::class);
    });

    /**Homes Services */
    Route::get('security/services/', [HomeServicesController::class, 'securityService'])->name('services.securityService');
    Route::get('domain/services/', [HomeServicesController::class, 'domainService'])->name('services.domainService');
    Route::get('people/services/', [HomeServicesController::class, 'peopleService'])->name('services.peopleService');
    Route::get('structure/services/', [HomeServicesController::class, 'structureService'])->name('services.structureService');


});

require __DIR__.'/auth.php';

