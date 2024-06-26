<?php

namespace App\Http\Controllers\Dashboards;

use App\Charts\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Contract\MonthlyPayment;
use App\Models\Tution\LowerMonthlyFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardsController extends Controller
{

    public function __construct(LowerMonthlyFee $LowerMonthlyFee, MonthlyPayment $MonthlyPayment)
    {
        $this->LowerMonthlyFee = $LowerMonthlyFee;
        $this->MonthlyPayment = $MonthlyPayment;
    }

    public function financialDashboard(Request $request){

        $query_total_receivable = DB::table('monthly_payments')->selectRaw('sum(total_payable) as total_payable')->where('id_monthly_status', '<>', 'C');
        $query_total_paid = DB::table('monthly_payments')->selectRaw('sum(amount_paid) as total_paid')->where('id_monthly_status', '<>', 'C');
        $query_total_received = DB::table('monthly_payments')->selectRaw('sum(balance_value) as balance_value')->where('id_monthly_status', '<>', 'C');

        $query_money = DB::table('lower_monthly_fees')->selectRaw('sum(amount_paid) as money')->where('id_type_payment', '=', 'D');

        $query_pix = DB::table('monthly_payments')
                            ->selectRaw('sum(lower_monthly_fees.amount_paid) as pix_value')
                            ->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment')
                            ->where('lower_monthly_fees.id_type_payment', '=', 'P');


        $query_debit_card = DB::table('lower_monthly_fees')->selectRaw('sum(amount_paid) as debit_card')->where('id_type_payment', '=', 'CD');
        $query_credit_card = DB::table('lower_monthly_fees')->selectRaw('sum(amount_paid) as credit_card')->where('id_type_payment', '=', 'CC');

        if($request->due_date_initial && $request->due_date_final){
            $query_total_receivable->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $query_total_paid->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $query_total_received->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            // $query_money;
            $query_pix->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            // $query_debit_card;
            // $query_credit_card;
        }

        $total_receivable = $query_total_receivable->first();
        $total_paid = $query_total_paid->first();
        $total_received = $query_total_received->first();

        $pix = $query_pix->first();

        //dd($pix->pix_value);

        //dd($total_receivable->total_payable);

        // $dashboard = new Dashboard;

        // $dashboard->labels(['Pix', 'Dinheiro', 'Cartão Débito','Cartão Crédito' ]);

        // $dashboard->dataset('Valores Recebidos', 'bar', [$pix,$money,$debit_card,$credit_card])->backgroundColor(['#227093','#218c74','#84817a','#2c2c54']);

        return view('dashboards.dashboard', compact(['total_receivable', 'total_paid', 'total_received', 'pix']));
        //  return view('dashboards.dashboard', compact(['dashboard', 'pix', 'money','debit_card','credit_card','total_receivable', 'total_paid', 'total_received']));
    }
}
