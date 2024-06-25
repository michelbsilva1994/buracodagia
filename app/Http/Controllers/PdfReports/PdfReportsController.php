<?php

namespace App\Http\Controllers\PdfReports;

use App\Http\Controllers\Controller;
use App\Models\Contract\MonthlyPayment;
use App\Models\Tution\LowerMonthlyFee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelReport;

class PdfReportsController extends Controller
{
    public function __construct(MonthlyPayment $monthlyPayment, LowerMonthlyFee $LowerMonthlyFee){
        $this->monthlyPayment = $monthlyPayment;
        $this->LowerMonthlyFee = $LowerMonthlyFee;
    }

    public function receipt($id_receipt){
        // $monthlyPayment = $this->monthlyPayment->where('id', $id_receipt)->first();

        $monthlyPayment = DB::table('contracts')
                    ->selectRaw('contracts.name_contractor as name_contractor,
                    contracts.id as id_contract,
                    monthly_payments.download_user as download_user,
                    monthly_payments.id as id_monthly_payment,
                    monthly_payments.dt_payday as dt_payday,
                    monthly_payments.due_date as due_date,
                    monthly_payments.total_payable as total_payable,
                    monthly_payments.amount_paid as amount_paid,
                    monthly_payments.balance_value as balance_value,
                    monthly_payments.id_monthly_status as id_monthly_status,
                    GROUP_CONCAT(distinct stores.name) as stores,
                    GROUP_CONCAT(distinct pavements.name) as pavements,
                    GROUP_CONCAT(distinct store_types.description) as types_stores
                    '
                    )
                    ->rightJoin('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                    ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                    ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                    ->leftJoin('store_types', 'stores.type', '=', 'store_types.value')
                    ->leftJoin('pavements', 'stores.id_pavement', '=', 'pavements.id')
                    ->where('monthly_payments.id', '=', $id_receipt)
                    ->groupByRaw('monthly_payments.id')->first();

                    $data = ['monthlyPayment' => $monthlyPayment];
                    $pdfReceipt = Pdf::loadView('pdf_reports.receipt', $data);
                    return $pdfReceipt->stream('recibo.pdf');
    }

    public function partialReceipt($id_receipt){

        $monthlyPayment = DB::table('contracts')
                    ->selectRaw('max(lower_monthly_fees.dt_payday) as dt_payday_partial,
                    contracts.name_contractor as name_contractor,
                    contracts.id as id_contract,
                    monthly_payments.download_user as download_user,
                    monthly_payments.id as id_monthly_payment,
                    monthly_payments.dt_payday as dt_payday,
                    monthly_payments.due_date as due_date,
                    monthly_payments.total_payable as total_payable,
                    monthly_payments.amount_paid as amount_paid,
                    monthly_payments.balance_value as balance_value,
                    monthly_payments.id_monthly_status as id_monthly_status,
                    GROUP_CONCAT(distinct stores.name) as stores,
                    GROUP_CONCAT(distinct pavements.name) as pavements,
                    GROUP_CONCAT(distinct store_types.description) as types_stores'
                    )
                    ->rightJoin('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                    ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                    ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                    ->leftJoin('store_types', 'stores.type', '=', 'store_types.value')
                    ->leftJoin('pavements', 'stores.id_pavement', '=', 'pavements.id')
                    ->leftJoin('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment')
                    ->where('monthly_payments.id', '=', $id_receipt)
                    ->groupByRaw('monthly_payments.id')->first();

        $data = ['monthlyPayment' => $monthlyPayment];
        $pdfPatialRecceipt = Pdf::loadView('pdf_reports.partialReceipt', $data);
        return $pdfPatialRecceipt->stream('recibo_parcial.pdf');
    }
}
