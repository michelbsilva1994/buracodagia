<?php

use App\Http\Controllers\Contract\ContractController;
use App\Http\Controllers\Dashboards\DashboardsController;
use App\Http\Controllers\Domain\ContractCancellationTypeController;
use App\Http\Controllers\Domain\StoreStatusController;
use App\Http\Controllers\Domain\StoreTypeController;
use App\Http\Controllers\Domain\TypeCancellationController;
use App\Http\Controllers\Domain\TypeChargeController;
use App\Http\Controllers\Domain\TypeContractController;
use App\Http\Controllers\Domain\TypePayment;
use App\Http\Controllers\MonthlyPaymentController;
use App\Http\Controllers\PdfReports\PdfReportsController;
use App\Http\Controllers\Permissions\RoleController as PermissionsRoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\People\PhysicalPersonController;
use App\Http\Controllers\People\LegalPersonController;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\Services\HomeServiceDomainController;
use App\Http\Controllers\Services\HomeServicesController;
use App\Http\Controllers\Services\HomeServiceSecurityController;
use App\Http\Controllers\Services\ServiceOrderController;
use App\Http\Controllers\Structure\EquipmentController;
use App\Http\Controllers\Structure\PavementController;
use App\Http\Controllers\Structure\StoreController;
use App\Models\Contract\MonthlyPayment;
use App\Models\Domain\TypeCharge;
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
    return view('auth.login');
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

    /**rota filtrar pessoal fisica */
    Route::get('physicalPerson/physicalIndex', [PhysicalPersonController::class, 'physicalIndex'])->name('physical.physicalIndex');
    Route::get('contractPerson/{id_person}', [PhysicalPersonController::class, 'contractPerson'])->name('physical.contractPerson');
    Route::resource('physicalPerson', PhysicalPersonController::class);

    Route::get('legalPerson/filter', [LegalPersonController::class, 'filter'])->name('legalPerson.filter');
    Route::resource('legalPerson', LegalPersonController::class);

    /**Structure*/
    Route::resource('pavement', PavementController::class);
    Route::resource('store', StoreController::class);
    Route::resource('equipment', EquipmentController::class);

    /**Services */
    Route::post('serviceOrder/history/{serviceOrder}', [ServiceOrderController::class, 'storeHistory'])->name('serviceOrders.storeHistory');
    Route::get('serviceOrderindex/', [ServiceOrderController::class, 'serviceOrderindex'])->name('serviceOrders.serviceOrderindex');
    Route::post('startWorkOrder/', [ServiceOrderController::class, 'startWorkOrder'])->name('serviceOrders.startWorkOrder');
    Route::post('closeWorkOrder/', [ServiceOrderController::class, 'closeWorkOrder'])->name('serviceOrders.closeWorkOrder');
    Route::resource('serviceOrders', ServiceOrderController::class);

    Route::delete('contract/{contractRemoveStore}/removeStore', [ContractController::class, 'contractRemoveStore'])->name('contract.removeStore');
    Route::put('contract/signContract/{contract}', [ContractController::class, 'signContract'])->name('contract.singContract');
    Route::put('contract/reverseContractSignature/{contract}', [ContractController::class, 'reverseContractSignature'])->name('contract.reverseContractSignature');
    Route::post('contract/contractStore/{contract}', [ContractController::class, 'contractStore'])->name('contract.contractStore');
    Route::post('contract/cancelContract/{contract}', [ContractController::class, 'cancelContract'])->name('contract.cancelContract');
    Route::resource('contract', ContractController::class);

    /**Generate Tuition */
    Route::post('reverseMonthlyPayment/', [MonthlyPaymentController::class, 'reverse_monthly_payment'])->name('monthly.reverseMonthlyPayment');
    Route::post('reverseLowerMonthlyFeeIndex/', [MonthlyPaymentController::class, 'reverse_lower_monthly_fees'])->name('monthly.reverseLowerMonthlyFeeIndex');
    Route::get('lowerMonthlyFeeIndex/{id_monthly}', [MonthlyPaymentController::class, 'view_lower_monthly_fees'])->name('monthly.lowerMonthlyFeeIndex');
    Route::get('tuition/tuitionAjax', [MonthlyPaymentController::class, 'tuitionAjax'])->name('monthly.tuitionAjax');
    Route::get('createGenerateRetroactiveMonthlyPayment', [MonthlyPaymentController::class, 'createGenerateRetroactiveMonthlyPayment'])->name('monthly.createGenerateRetroactiveMonthlyPayment');
    Route::post('generateRetroactiveMonthlyPayment', [MonthlyPaymentController::class, 'generateRetroactiveMonthlyPayment'])->name('monthly.generateRetroactiveMonthlyPayment');
    Route::get('MonthlyPaymentContract/{contract}', [MonthlyPaymentController::class, 'monthlyPaymentContract'])->name('monthly.MonthlyPaymentContract');
    Route::post('lowerMonthlyFee/',[MonthlyPaymentController::class, 'lowerMonthlyFee'])->name('monthly.lowerMonthlyFee');
    Route::post('lowerMonthlyFeeContract/',[MonthlyPaymentController::class, 'lowerMonthlyFeeContract'])->name('monthly.lowerMonthlyFeeContract');
    Route::post('cancelTuition/',[MonthlyPaymentController::class, 'cancelTuition'])->name('monthly.cancelTuition');
    Route::post('cancelTuitionContract/',[MonthlyPaymentController::class, 'cancelTuitionContract'])->name('monthly.cancelTuitionContract');
    Route::get('tuition/', [MonthlyPaymentController::class, 'tuition'])->name('monthly.tuition');
    Route::get('tuition/filter',[MonthlyPaymentController::class, 'filter'])->name('monthly.filter');
    Route::resource('monthly', MonthlyPaymentController::class);


    /**Domain */
    Route::prefix('domain')->group(function(){
        Route::get('/typeContract/indexAjax', [TypeContractController::class, 'indexAjax'])->name('typeContract.indexAjax');
        Route::resource('typeContract', TypeContractController::class);
        Route::resource('storeType', StoreTypeController::class);
        Route::resource('storeStatus', StoreStatusController::class);
        Route::resource('typePayment', TypePayment::class);
        Route::resource('typeCharge', TypeChargeController::class);
        Route::resource('typeCancellation', TypeCancellationController::class);
        Route::resource('contractCancellationType', ContractCancellationTypeController::class);
    });

    /**Homes Services */
    Route::get('security/services/', [HomeServicesController::class, 'securityService'])->name('services.securityService');
    Route::get('domain/services/', [HomeServicesController::class, 'domainService'])->name('services.domainService');
    Route::get('people/services/', [HomeServicesController::class, 'peopleService'])->name('services.peopleService');
    Route::get('structure/services/', [HomeServicesController::class, 'structureService'])->name('services.structureService');
    Route::get('generationTuitions/services/', [HomeServicesController::class, 'generationTuitions'])->name('services.generationTuitions');

    /**Reports */

    /**Index Reports */
    Route::get('reports/index', [ReportsController::class, 'reportsIndex'])->name('reports.index');

    /** Reports Views */
    Route::get('reports/contractStores/index', [ReportsController::class, 'reportContractStoresIndex'])->name('reports.contractStoresIndex');
    Route::get('reports/Stores/index', [ReportsController::class, 'reportStoresIndex'])->name('reports.storesIndex');
    Route::get('reports/lowersTuition/index', [ReportsController::class, 'reportLowersTuition'])->name('reports.lowersTuitionIndex');

    /**Rota para pegar lojas por pavimento */
    Route::get('/reports/stores/by-pavement/{pavement_id?}', [ReportsController::class, 'getStoreByPavement'])->name('reports.storesByPavement');

    /** Generation Reports */
    Route::post('reports/contractStores/', [ReportsController::class, 'reportContractStores'])->name('reports.reportContractStores');
    Route::post('reports/Stores/', [ReportsController::class, 'reportStores'])->name('reports.reportStores');
    Route::post('reports/lowersTuition/', [ReportsController::class, 'lowersTuition'])->name('reports.lowersTuition');

    /** PDF Reports */
    Route::get('pdfReports/receipt/{id_receipt}', [PdfReportsController::class, 'receipt'])->name('pdfReports.receipt');
    Route::get('pdfReports/partialReceipt/{id_receipt}', [PdfReportsController::class, 'partialReceipt'])->name('pdfReports.partialReceipt');

    /** Dashboards */
    Route::get('/dashboard/index', [DashboardsController::class, 'dashboardIndex'])->name('dashboardCharts.dashboardChartsIndex');
    Route::get('/dashboardCharts/charts', [DashboardsController::class, 'financialDashboard'])->name('dashboardCharts.dashboardCharts');
    Route::get('/financialLowersDashboard/charts', [DashboardsController::class, 'financialLowersDashboard' ])->name('dashboardCharts.financialLowersDashboard');
});

require __DIR__.'/auth.php';

