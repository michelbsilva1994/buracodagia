<?php

namespace App\Http\Controllers\Reports;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelReport;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{

    public function reportUsersIndex(){
        return view('reports.index');
    }

    public function reportContractStoresIndex(){
        return view('reports.report_contract_stores');
    }

    public function reportUsers(Request $request){
        $name = $request->name;

        $query = DB::table('users')
                    ->selectRaw('id,name, email');

        if($name){
            $query->where('name', 'like',"%$name%");
        }

        $users = $query->get();

        return $users->downloadExcel('users.xlsx', ExcelReport::XLSX ,true);
    }

    public function reportContractStores(Request $request){

        dd($request);

        $query  = DB::table('contracts')
                        ->selectRaw('contracts.id as id_contrato,
                                     contracts.name_contractor as contratante,
                                     contracts.total_price as valor_contrato,
                                     contracts.dt_signature as dt_assinatura,
                                     GROUP_CONCAT(stores.name) as lojas,
                                     GROUP_CONCAT(pavements.name) as pavimento
                                     ')
                        ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                        ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                        ->leftJoin('pavements', 'stores.id_pavement', '=', 'pavements.id')
                        ->whereRaw('dt_signature is not null')
                        ->whereRaw('dt_cancellation is null')
                        ->groupByRaw('contracts.id');

        $contracts = $query->get();

        return $contracts->downloadExcel('contratos.xlsx', ExcelReport::XLSX, true);
    }
}
