<?php

namespace App\Http\Controllers\Dashboards;

use App\Charts\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Contract\MonthlyPayment;
use App\Models\Structure\Pavement;
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

    public function dashboardIndex(){
        return view('dashboards.dashboardIndex');
    }

    public function financialDashboard(Request $request){

        $pavements = Pavement::where('status','A')->get();
        //Valores totais das mensalidades por data de vencimento da mensalidade

        $queryTotalTuition = DB::table('monthly_payments')
                                ->selectRaw('distinct monthly_payments.id, monthly_payments.total_payable, monthly_payments.amount_paid, monthly_payments.balance_value')
                                ->Join('contract_stores','monthly_payments.id_contract', 'contract_stores.id_contract')->Join('stores','contract_stores.id_store','stores.id')
                                ->Join('pavements','stores.id_pavement','pavements.id')
                                ->where('monthly_payments.id_monthly_status', '<>', 'C')
                                ->orderBy('monthly_payments.id');

        $queryTotalLowerByPaymentType = DB::table('lower_monthly_fees')
                                        ->selectRaw('distinct lower_monthly_fees.id, pavements.id pavement, lower_monthly_fees.amount_paid, lower_monthly_fees.id_type_payment')
                                        ->Join('monthly_payments', 'lower_monthly_fees.id_monthly_payment','monthly_payments.id')
                                        ->Join('contracts','monthly_payments.id_contract', 'contracts.id')
                                        ->Join('contract_stores','contracts.id', 'contract_stores.id_contract')
                                        ->Join('stores','contract_stores.id_store','stores.id')
                                        ->Join('pavements','stores.id_pavement','pavements.id');

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
            $queryTotalLowerByPaymentType->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $queryTuitionPavement->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
            $queryLowerTuitionPavement->where('monthly_payments.due_date', '>=' ,$request->due_date_initial)->where('monthly_payments.due_date', '<=' ,$request->due_date_final);
        }

        //Filtrando queries por pavimento

        if($request->pavement){
            $queryTotalTuition->where('pavements.id', $request->pavement);
            $queryTotalLowerByPaymentType->where('pavements.id', $request->pavement);
            $queryTuitionPavement->where('pavements.id', $request->pavement);
            $queryLowerTuitionPavement->where('pavements.id', $request->pavement);
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
        $money = 0;
        $pix = 0;
        $debit_card = 0;
        $credit_card = 0;

        $totalLowerByPaymentType = $queryTotalLowerByPaymentType->get();

        foreach($totalLowerByPaymentType as $valueLowerByPaymentType){
            if($valueLowerByPaymentType->id_type_payment === 'D'){
                $money += $valueLowerByPaymentType->amount_paid;
            }
            if($valueLowerByPaymentType->id_type_payment === 'P'){
                $pix += $valueLowerByPaymentType->amount_paid;
            }
            if($valueLowerByPaymentType->id_type_payment === 'CD'){
                $debit_card += $valueLowerByPaymentType->amount_paid;
            }
            if($valueLowerByPaymentType->id_type_payment === 'CC'){
                $credit_card += $valueLowerByPaymentType->amount_paid;
            }
        }

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
                        ['pavements', 'pix', 'money','debit_card','credit_card','dataTotalTuition','dataTotalTuition_t',
                        'totalLowerTuitionPavementOne','totalLowerTuitionPavementTwo','totalLowerTuitionPavementThree'
                        ]))->render();
            return response()->json(['items' => $dashboard, 'lowers' => $dashboardLowers ,'html' => $view]);
        }

        return view('dashboards.dashboard', compact(
            ['pavements','dashboard','dashboardLowers', 'pix', 'money','debit_card','credit_card','dataTotalTuition', 'dataTotalTuition_t',
             'totalLowerTuitionPavementOne','totalLowerTuitionPavementTwo','totalLowerTuitionPavementThree'
            ]
        ));
    }

    public function financialLowersDashboard(Request $request){
        $pavements = Pavement::where('status','A')->get();

        $queryLowers = DB::table('lower_monthly_fees')
                                    ->selectRaw('distinct lower_monthly_fees.id, pavements.id pavement, lower_monthly_fees.amount_paid, lower_monthly_fees.id_type_payment')
                                    ->Join('monthly_payments', 'lower_monthly_fees.id_monthly_payment','monthly_payments.id')
                                    ->Join('contracts','monthly_payments.id_contract', 'contracts.id')
                                    ->Join('contract_stores','contracts.id', 'contract_stores.id_contract')
                                    ->Join('stores','contract_stores.id_store','stores.id')
                                    ->Join('pavements','stores.id_pavement','pavements.id');

        if($request->date_initial && $request->date_final){
            $queryLowers->where('lower_monthly_fees.dt_payday', '>=' ,$request->due_date_initial)->where('lower_monthly_fees.dt_payday', '<=' ,$request->due_date_final);
        }
        if($request->pavement){
            $queryLowers->where('pavements.id', $request->pavement);
        }

        $lowers = $queryLowers->get();

        //Total geral

        $totalLowers = 0;
        foreach($lowers as $lower){
            $totalLowers += $lower->amount_paid;
        }

        //Por tipo de baixa

        $money = 0;
        $pix = 0;
        $debit_card = 0;
        $credit_card = 0;

        foreach($lowers as $valueLowerByPaymentType){
            if($valueLowerByPaymentType->id_type_payment === 'D'){
                $money += $valueLowerByPaymentType->amount_paid;
            }
            if($valueLowerByPaymentType->id_type_payment === 'P'){
                $pix += $valueLowerByPaymentType->amount_paid;
            }
            if($valueLowerByPaymentType->id_type_payment === 'CD'){
                $debit_card += $valueLowerByPaymentType->amount_paid;
            }
            if($valueLowerByPaymentType->id_type_payment === 'CC'){
                $credit_card += $valueLowerByPaymentType->amount_paid;
            }
        }

        //Por pavimento

        $totalLowerTuitionPavementOne = 0;
        $totalLowerTuitionPavementTwo = 0;
        $totalLowerTuitionPavementThree = 0;

        foreach($lowers as $lowerMonthlyPavement){
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
        $totalLowerTuitionPavement = [
                $totalLowerTuitionPavementOne,
                $totalLowerTuitionPavementTwo,
                $totalLowerTuitionPavementThree
            ];

            if($request->ajax()){
                $view = view('dashboards.financial_dashboard.financial_dashboard_lowers_data', compact(
                            ['pavements','totalLowers',
                             'money', 'pix', 'debit_card', 'credit_card',
                             'totalLowerTuitionPavement'
                            ]))->render();
                return response()->json(['html' => $view]);
            }

        return  view('dashboards.dashboardLowers',
                compact(['pavements','totalLowers',
                         'money', 'pix', 'debit_card', 'credit_card',
                         'totalLowerTuitionPavement'
                        ]));
    }
}
