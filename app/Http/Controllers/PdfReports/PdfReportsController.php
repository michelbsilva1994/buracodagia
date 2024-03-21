<?php

namespace App\Http\Controllers\PdfReports;

use App\Http\Controllers\Controller;
use App\Models\Contract\MonthlyPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfReportsController extends Controller
{
    public function __construct(MonthlyPayment $monthlyPayment){
        $this->monthlyPayment = $monthlyPayment;
    }

    public function receipt($id_receipt){
        // $monthlyPayment = $this->monthlyPayment->where('id', $id_receipt)->first();

        $monthlyPayment = DB::table('contracts')
                    ->selectRaw('contracts.name_contractor as name_contractor,
                    monthly_payments.id as id_monthly_payment,
                    monthly_payments.due_date as due_date,
                    monthly_payments.total_payable as total_payable,
                    monthly_payments.amount_paid as amount_paid,
                    monthly_payments.balance_value as balance_value,
                    monthly_payments.id_monthly_status as id_monthly_status,
                    GROUP_CONCAT(stores.name) as stores'
                    )
                    ->rightJoin('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                    ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                    ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                    ->leftJoin('pavements', 'stores.id_pavement', '=', 'pavements.id')
                    ->where('monthly_payments.id', '=', $id_receipt)
                    ->groupByRaw('monthly_payments.id')->first();

        $data = ['monthlyPayment' => $monthlyPayment];
        $pdfReceipt = Pdf::loadView('pdf_reports.receipt', $data);
        return $pdfReceipt->stream('receibo.pdf');
    }
}
