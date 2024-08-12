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

        $queryTotalTuition = DB::table('monthly_payments')
                                ->selectRaw('distinct monthly_payments.id, monthly_payments.total_payable, monthly_payments.amount_paid, monthly_payments.balance_value')
                                ->Join('contract_stores','monthly_payments.id_contract', 'contract_stores.id_contract')->Join('stores','contract_stores.id_store','stores.id')
                                ->Join('pavements','stores.id_pavement','pavements.id')
                                ->where('monthly_payments.id_monthly_status', '<>', 'C')
                                ->orderBy('monthly_payments.id');

        $query_money = DB::table('monthly_payments')->selectRaw('sum(lower_monthly_fees.amount_paid) as money_value')->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment')->where('lower_monthly_fees.id_type_payment', '=', 'D')->whereNull('lower_monthly_fees.id_lower_monthly_fees_reverse');
        $query_pix = DB::table('monthly_payments')->selectRaw('sum(lower_monthly_fees.amount_paid) as pix_value')->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment')->where('lower_monthly_fees.id_type_payment', '=', 'P')->whereNull('lower_monthly_fees.id_lower_monthly_fees_reverse');
        $query_debit_card = DB::table('monthly_payments')->selectRaw('sum(lower_monthly_fees.amount_paid) as debit_card_value')->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment')->where('lower_monthly_fees.id_type_payment', '=', 'CD')->whereNull('lower_monthly_fees.id_lower_monthly_fees_reverse');
        $query_credit_card = DB::table('monthly_payments')->selectRaw('sum(lower_monthly_fees.amount_paid) as credit_card_value')->Join('lower_monthly_fees','monthly_payments.id','=','lower_monthly_fees.id_monthly_payment')->where('lower_monthly_fees.id_type_payment', '=', 'CC')->whereNull('lower_monthly_fees.id_lower_monthly_fees_reverse');

        $queryTuitionPavement = DB::table('monthly_payments')
                                ->selectRaw('distinct monthly_payments.id, pavements.id, monthly_payments.total_payable')
                                ->Join('contract_stores','monthly_payments.id_contract', 'contract_stores.id_contract')->Join('stores','contract_stores.id_store','stores.id')
                                ->Join('pavements','stores.id_pavement','pavements.id')
                                ->where('monthly_payments.id_monthly_status', '<>', 'C')
                                ->orderBy('monthly_payments.id');

        // Valores totais baixa por pavimento por data de vencimento da mensalidade

        $queryLowerTuitionPavement = DB::table('lower_monthly_fees')
                            ->selectRaw('lower_monthly_fees.id, pavements.id pavement, lower_monthly_fees.amount_paid')
                            ->Join('monthly_payments', 'lower_monthly_fees.id_monthly_payment','monthly_payments.id')
                            ->Join('contracts','monthly_payments.id_contract', 'contracts.id')
                            ->Join('contract_stores','contracts.id', 'contract_stores.id_contract')
                            ->Join('stores','contract_stores.id_store','stores.id')
                            ->Join('pavements','stores.id_pavement','pavements.id')
                            ->groupByRaw('lower_monthly_fees.id, pavements.id');

        //Filtrando as queries por data de vencimento da mensalidade
        if($request->due_date_initial && $request->due_date_final){
            $queryTotalTuition->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);

            $query_money->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $query_pix->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $query_debit_card->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $query_credit_card->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);

            $queryTuitionPavement->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);

            $queryLowerTuitionPavement->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
        }

        //obtendo valores das querys

        //Valores das queries totais das mensalidades
        $totalTuition = $queryTotalTuition->get();

        $total_receivable_t = 0;
        $total_paid_t = 0;
        $total_received_t = 0;

        foreach($totalTuition as $valueTotalTuition){
            $total_receivable_t += $valueTotalTuition->total_payable;
            $total_paid_t += $valueTotalTuition->amount_paid;
            $total_received_t += $valueTotalTuition->balance_value;
        }

        $dataTotalTuition_t = [
            $total_receivable_t,
            $total_paid_t,
            $total_received_t
        ];

        //dd($dataTotalTuition);

        $money = $query_money->first();
        $pix = $query_pix->first();
        $debit_card = $query_debit_card->first();
        $credit_card = $query_credit_card->first();

        $money = $money->money_value;
        $pix = $pix->pix_value;
        $debit_card =  $debit_card->debit_card_value;
        $credit_card =  $credit_card->credit_card_value;

         //queries valores totais a receber por pavimento por data de vencimento da mensalidade
        $tuitionPavement = $queryTuitionPavement->get();

        $totalTuitionPavementOne = 0;
        $totalTuitionPavementTwo = 0;
        $totalTuitionPavementThree = 0;

        foreach($tuitionPavement as $monthly){
                if($monthly->id === 1){
                    $totalTuitionPavementOne += $monthly->total_payable;
                }
                if($monthly->id === 2){
                    $totalTuitionPavementTwo += $monthly->total_payable;
                }
                if($monthly->id === 3){
                    $totalTuitionPavementThree += $monthly->total_payable;
                }
            }

            $dataTotalTuition = [
                $totalTuitionPavementOne,
                $totalTuitionPavementTwo,
                $totalTuitionPavementThree
            ];

        //query baixa por pavimento e data de vencimento
        $LowerTuitionPavement = $queryLowerTuitionPavement->get();

        $totalLowerTuitionPavementOne = 0;
        $totalLowerTuitionPavementTwo = 0;
        $totalLowerTuitionPavementThree = 0;

        foreach($LowerTuitionPavement as $lowerMonthlyPavement){
                    if($lowerMonthlyPavement->pavement === 1){
                        $totalLowerTuitionPavementOne += $lowerMonthlyPavement->amount_paid;
                    }
                    if($lowerMonthlyPavement->pavement === 2){
                        $totalLowerTuitionPavementTwo += $lowerMonthlyPavement->amount_paid;
                    }
                    if($lowerMonthlyPavement->pavement === 3){
                        $totalLowerTuitionPavementThree += $lowerMonthlyPavement->amount_paid;
                    }
                }

        $dataLowersPavements = [
            $totalLowerTuitionPavementOne,
            $totalLowerTuitionPavementTwo,
            $totalLowerTuitionPavementThree
        ];

        $dashboard = new Dashboard;
        $dashboard->labels(['Pix', 'Dinheiro', 'Cartão Débito','Cartão Crédito' ]);
        $dashboard->dataset('Valores Recebidos', 'bar', [$pix,$money,$debit_card,$credit_card])->backgroundColor(['#227093','#218c74','#84817a','#2c2c54']);

        $dashboardLowers = new Dashboard;
        $dashboardLowers->labels(['Shopping Chão', 'Sub-Solo','Expansão']);
        $dashboardLowers->dataset('Valores de Baixa','bar', $dataLowersPavements);

        if($request->ajax()){
            $view = view('dashboards.financial_dashboard.financial_dashboard_data', compact(
                        ['pix', 'money','debit_card','credit_card','dataTotalTuition','dataTotalTuition_t',
                        // 'totalTuitionPavementOne','totalTuitionPavementTwo','totalTuitionPavementThree',
                        'totalLowerTuitionPavementOne','totalLowerTuitionPavementTwo','totalLowerTuitionPavementThree'
                        ]))->render();
            return response()->json(['items' => $dashboard, 'lowers' => $dashboardLowers ,'html' => $view]);
        }

        return view('dashboards.dashboard', compact(
            ['dashboard','dashboardLowers', 'pix', 'money','debit_card','credit_card','dataTotalTuition', 'dataTotalTuition_t',
            //  'totalTuitionPavementOne','totalTuitionPavementTwo','totalTuitionPavementThree',
             'totalLowerTuitionPavementOne','totalLowerTuitionPavementTwo','totalLowerTuitionPavementThree'
            ]
        ));
    }
}
