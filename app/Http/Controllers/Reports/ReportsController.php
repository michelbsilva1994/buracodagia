<?php

namespace App\Http\Controllers\Reports;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Domain\TypePayment;
use App\Models\Structure\Pavement;
use App\Models\Structure\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelReport;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{

    public function __construct(Pavement $pavement, Store $store, TypePayment $type_payment){
        $this->pavement = $pavement;
        $this->store = $store;
        $this->type_payment = $type_payment;
    }

    public function reportsIndex(){
        return view('reports.index');
    }

    public function reportContractStoresIndex(){
        $pavements = $this->pavement->where('status','A')->get();
        return view('reports.report_contract_stores', compact('pavements'));
    }

    public function reportContractStores(Request $request){

        $signature = $request->signed;
        $pavement = $request->pavement;

        $query  = DB::table('contracts')
                        ->selectRaw('contracts.id as id_contrato,
                                     contracts.name_contractor as contratante,
                                     contracts.total_price as valor_contrato,
                                     DATE_FORMAT(contracts.dt_signature, "%d/%m/%Y") as dt_assinatura,
                                     GROUP_CONCAT(stores.name) as lojas,
                                     GROUP_CONCAT(distinct pavements.name) as pavimento
                                     ')
                        ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                        ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                        ->leftJoin('pavements', 'stores.id_pavement', '=', 'pavements.id')
                        ->whereRaw('contracts.dt_cancellation is null')
                        ->groupByRaw('contracts.id');

        if($signature == '1'){
            $query;
        }
        if($signature == '2'){
            $query->whereRaw('dt_signature is not null');
        }
        if($signature == '3'){
            $query->whereRaw('contracts.dt_signature is null');
        }
        if($pavement){
            $query->where('pavements.id',$pavement);
        }

        $contracts = $query->get();

        return $contracts->downloadExcel('contratos.xlsx', ExcelReport::XLSX, true);
    }

    public function reportStoresIndex(){
        $pavements = $this->pavement->where('status','A')->get();
        return view('reports.report_stores', compact('pavements'));
    }

    public function reportStores(Request $request){

        $pavement = $request->pavement;

        $query = DB::table('stores')
                        ->selectRaw('stores.name as loja,
                                     pavements.name as pavimento')
                        ->join('pavements','stores.id_pavement','=', 'pavements.id')
                        ->where('stores.status','<>','O')
                        ->whereNotExists( function ($query) {
                            $query->select(DB::raw(1))
                            ->from('contract_stores')
                            ->join('contracts', 'contract_stores.id_contract', '=', 'contracts.id')
                            ->whereRaw('contracts.dt_cancellation is null')
                            ->whereRaw('stores.id = contract_stores.id_store');
                        });
        if($pavement){
            $query->where('pavements.id', $pavement);
        }

        $stores = $query->get();

        return $stores->downloadExcel('lojas_sem_contratos.xlsx', ExcelReport::XLSX, true);
    }

    public function reportLowersTuition(){
        $pavements = $this->pavement->where('status','A')->get();
        $stores = $this->store->get();
        $type_payments = $this->type_payment->where('status','A')->get();

        return view('reports.lowerTuition', compact('pavements', 'stores', 'type_payments'));
    }
    public function LowersTuition(Request $request){
        $queryLowersByPaymentType = DB::table('lower_monthly_fees')
                        ->selectRaw('distinct   lower_monthly_fees.id,
                                                lower_monthly_fees.id_monthly_payment as Mensalidade,
                                                monthly_payments.due_date as Vencimento,
                                                contracts.name_contractor as Contratante,
                                                pavements.name Pavimento,
                                                GROUP_CONCAT(stores.name) as Lojas,
                                                lower_monthly_fees.amount_paid as Valor_pago,
                                                lower_monthly_fees.type_payment as Tipo_pagamento,
                                                lower_monthly_fees.download_user as Usuario_baixa')
                        ->Join('monthly_payments', 'lower_monthly_fees.id_monthly_payment','monthly_payments.id')
                        ->Join('contracts','monthly_payments.id_contract', 'contracts.id')
                        ->Join('contract_stores','contracts.id', 'contract_stores.id_contract')
                        ->Join('stores','contract_stores.id_store','stores.id')
                        ->Join('pavements','stores.id_pavement','pavements.id')
                        ->whereRaw('lower_monthly_fees.id_lower_monthly_fees_reverse is null')
                        ->whereRaw('lower_monthly_fees.id_lower_monthly_fees_origin is null')
                        ->groupByRaw('lower_monthly_fees.id,contracts.name_contractor,pavements.name,
                                     lower_monthly_fees.amount_paid,lower_monthly_fees.type_payment,lower_monthly_fees.download_user,
                                      lower_monthly_fees.id_monthly_payment, monthly_payments.due_date');

        if($request->due_date_initial && $request->due_date_final){
            $queryLowersByPaymentType->where('lower_monthly_fees.dt_payday', '>=' ,$request->due_date_initial)->where('lower_monthly_fees.dt_payday', '<=' ,$request->due_date_final);
        }
        if($request->pavement){
            $queryLowersByPaymentType->where('pavements.id', $request->pavement);
        }
        if($request->store){
            $queryLowersByPaymentType->where('stores.id', $request->store);
        }
        if($request->type_payment){
            $queryLowersByPaymentType->where('lower_monthly_fees.id_type_payment', $request->type_payment);
        }


        $lowersByPaymentType = $queryLowersByPaymentType->get();
        return $lowersByPaymentType->downloadExcel('relatório_baixas.xlsx', ExcelReport::XLSX, true);
    }

}
