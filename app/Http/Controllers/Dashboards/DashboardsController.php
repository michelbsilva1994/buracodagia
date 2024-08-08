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

        //Valores totais das mensalidades por data de vencimento da mensalidade

        $query_total_receivable = DB::table('monthly_payments')->selectRaw('sum(total_payable) as total_payable')->where('id_monthly_status', '<>', 'C');
        $query_total_paid = DB::table('monthly_payments')->selectRaw('sum(amount_paid) as total_paid')->where('id_monthly_status', '<>', 'C');
        $query_total_received = DB::table('monthly_payments')->selectRaw('sum(balance_value) as balance_value')->where('id_monthly_status', '<>', 'C');

        $query_money = DB::table('monthly_payments')->selectRaw('sum(lower_monthly_fees.amount_paid) as money_value')->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment')->where('lower_monthly_fees.id_type_payment', '=', 'D')->whereNull('lower_monthly_fees.id_lower_monthly_fees_reverse');
        $query_pix = DB::table('monthly_payments')->selectRaw('sum(lower_monthly_fees.amount_paid) as pix_value')->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment')->where('lower_monthly_fees.id_type_payment', '=', 'P')->whereNull('lower_monthly_fees.id_lower_monthly_fees_reverse');
        $query_debit_card = DB::table('monthly_payments')->selectRaw('sum(lower_monthly_fees.amount_paid) as debit_card_value')->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment')->where('lower_monthly_fees.id_type_payment', '=', 'CD')->whereNull('lower_monthly_fees.id_lower_monthly_fees_reverse');
        $query_credit_card = DB::table('monthly_payments')->selectRaw('sum(lower_monthly_fees.amount_paid) as credit_card_value')->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment')->where('lower_monthly_fees.id_type_payment', '=', 'CC')->whereNull('lower_monthly_fees.id_lower_monthly_fees_reverse');

        $queryTuitionPavementOne = DB::table('monthly_payments')
                                ->selectRaw('distinct monthly_payments.id, pavements.name, monthly_payments.total_payable')
                                ->Join('contract_stores','monthly_payments.id_contract', 'contract_stores.id_contract')->Join('stores','contract_stores.id_store','stores.id')
                                ->Join('pavements','stores.id_pavement','pavements.id')->where('pavements.id', 1)->where('monthly_payments.id_monthly_status', '<>', 'C')
                                ->orderBy('monthly_payments.id');
        $queryTuitionPavementTwo = DB::table('monthly_payments')
                                ->selectRaw('distinct monthly_payments.id, pavements.name, monthly_payments.total_payable')
                                ->Join('contract_stores','monthly_payments.id_contract', 'contract_stores.id_contract')->Join('stores','contract_stores.id_store','stores.id')
                                ->Join('pavements','stores.id_pavement','pavements.id')->where('pavements.id', 2)->where('monthly_payments.id_monthly_status', '<>', 'C')
                                ->orderBy('monthly_payments.id');
        $queryTuitionPavementThree = DB::table('monthly_payments')
                                ->selectRaw('distinct monthly_payments.id, pavements.name, monthly_payments.total_payable')
                                ->Join('contract_stores','monthly_payments.id_contract', 'contract_stores.id_contract')->Join('stores','contract_stores.id_store','stores.id')
                                ->Join('pavements','stores.id_pavement','pavements.id')->where('pavements.id', 3)->where('monthly_payments.id_monthly_status', '<>', 'C')
                                ->orderBy('monthly_payments.id');

        // Baixa por pavimento por data de vencimento da mensalidade
        $queryLowerTuitionPavementOne = DB::table('monthly_payments')
                                ->selectRaw('sum(lower_monthly_fees.amount_paid) as total')
                                ->Join('contract_stores','monthly_payments.id_contract', 'contract_stores.id_contract')->Join('stores','contract_stores.id_store','stores.id')
                                ->Join('pavements','stores.id_pavement','pavements.id')->where('pavements.id', 1)->where('monthly_payments.id_monthly_status', '<>', 'C')
                                ->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment');

        $queryLowerTuitionPavementTwo = DB::table('monthly_payments')
                                ->selectRaw('sum(lower_monthly_fees.amount_paid) as total')
                                ->Join('contract_stores','monthly_payments.id_contract', 'contract_stores.id_contract')->Join('stores','contract_stores.id_store','stores.id')
                                ->Join('pavements','stores.id_pavement','pavements.id')->where('pavements.id', 2)->where('monthly_payments.id_monthly_status', '<>', 'C')
                                ->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment');

        $queryLowerTuitionPavementThree = DB::table('monthly_payments')
                                ->selectRaw('sum(lower_monthly_fees.amount_paid) as total')
                                ->Join('contract_stores','monthly_payments.id_contract', 'contract_stores.id_contract')->Join('stores','contract_stores.id_store','stores.id')
                                ->Join('pavements','stores.id_pavement','pavements.id')->where('pavements.id', 3)->where('monthly_payments.id_monthly_status', '<>', 'C')
                                ->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment');

        // $queryLowersPavements = DB::table('monthly_payments')
        //             ->selectRaw('sum(lower_monthly_fees.amount_paid) as total , pavements.name')
        //             ->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment')
        //             ->Join('contract_stores','monthly_payments.id_contract', 'contract_stores.id_contract')
        //             ->Join('stores','contract_stores.id_store','stores.id')
        //             ->Join('pavements','stores.id_pavement','pavements.id')
        //             ->where('monthly_payments.id_monthly_status', '<>', 'C')
        //             ->groupByRaw('pavements.name');

        $queryLowersPavements = DB::table('lower_monthly_fees')
                            ->selectRaw('distinct pavements.name')
                            ->selectRaw('(select sum(lower_monthly_fees.amount_paid) from lower_monthly_fees where lower_monthly_fees.id_monthly_payment = monthly_payments.id) as total')
                            ->Join('monthly_payments', 'lower_monthly_fees.id_monthly_payment','monthly_payments.id')
                            ->Join('contracts','monthly_payments.id_contract', 'contracts.id')
                            ->Join('contract_stores','contracts.id', 'contract_stores.id_contract')
                            ->Join('stores','contract_stores.id_store','stores.id')
                            ->Join('pavements','stores.id_pavement','pavements.id')
                            //->groupBy('pavements.name')
                            ->get();

        dd($queryLowersPavements);

        //Filtrando as queries por data de vencimento da mensalidade
        if($request->due_date_initial && $request->due_date_final){
            $query_total_receivable->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $query_total_paid->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $query_total_received->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);

            $query_money->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $query_pix->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $query_debit_card->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $query_credit_card->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);

            $queryTuitionPavementOne->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $queryTuitionPavementTwo->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $queryTuitionPavementThree->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);

            $queryLowerTuitionPavementOne->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $queryLowerTuitionPavementTwo->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $queryLowerTuitionPavementThree->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);

            $queryLowersPavements->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
        }

        //obtendo valores das querys

        //Valores das queries totais das mensalidades
        $total_receivable = $query_total_receivable->first();
        $total_paid = $query_total_paid->first();
        $total_received = $query_total_received->first();

        $money = $query_money->first();
        $pix = $query_pix->first();
        $debit_card = $query_debit_card->first();
        $credit_card = $query_credit_card->first();

        $money = $money->money_value;
        $pix = $pix->pix_value;
        $debit_card =  $debit_card->debit_card_value;
        $credit_card =  $credit_card->credit_card_value;

         // Valores das queries de baixas por pavimento por data de vencimento da mensalidade
        $tuitionPavementOne = $queryTuitionPavementOne->get();
        $tuitionPavementTwo = $queryTuitionPavementTwo->get();
        $tuitionPavementThree = $queryTuitionPavementThree->get();

        $lowerTuitionPavementOne = $queryLowerTuitionPavementOne->first();
        $lowerTuitionPavementTwo = $queryLowerTuitionPavementTwo->first();
        $lowerTuitionPavementThree = $queryLowerTuitionPavementThree->first();

        $totalTuitionPavementOne = 0;
        foreach($tuitionPavementOne as $tuitionPavement){$totalTuitionPavementOne += $tuitionPavement->total_payable;}
        $totalTuitionPavementTwo = 0;
        foreach($tuitionPavementTwo as $tuitionPavement){$totalTuitionPavementTwo += $tuitionPavement->total_payable;}
        $totalTuitionPavementThree = 0;
        foreach($tuitionPavementThree as $tuitionPavement){$totalTuitionPavementThree += $tuitionPavement->total_payable;}

        //query por data de vencimento
        $LowersPavements = $queryLowersPavements->get();
        //dd($LowersPavements);

        $dashboard = new Dashboard;
        $dashboard->labels(['Pix', 'Dinheiro', 'Cartão Débito','Cartão Crédito' ]);
        $dashboard->dataset('Valores Recebidos', 'bar', [$pix,$money,$debit_card,$credit_card])->backgroundColor(['#227093','#218c74','#84817a','#2c2c54']);

        $dashboardLowers = new Dashboard;
        $dashboardLowers->labels($LowersPavements);
        $dashboardLowers->dataset('Valores de Baixa','bar',$LowersPavements);

        if($request->ajax()){
            $view = view('dashboards.financial_dashboard.financial_dashboard_data', compact(
                        ['pix', 'money','debit_card','credit_card','total_receivable', 'total_paid', 'total_received',
                        'totalTuitionPavementOne','totalTuitionPavementTwo','totalTuitionPavementThree',
                        'lowerTuitionPavementOne','lowerTuitionPavementTwo','lowerTuitionPavementThree'
                        ]))->render();
            return response()->json(['items' => $dashboard, 'lowers' => $dashboardLowers ,'html' => $view]);
        }

        return view('dashboards.dashboard', compact(
            ['dashboard','dashboardLowers', 'pix', 'money','debit_card','credit_card','total_receivable', 'total_paid', 'total_received',
             'totalTuitionPavementOne','totalTuitionPavementTwo','totalTuitionPavementThree',
             'lowerTuitionPavementOne','lowerTuitionPavementTwo','lowerTuitionPavementThree'
            ]
        ));
    }
}
