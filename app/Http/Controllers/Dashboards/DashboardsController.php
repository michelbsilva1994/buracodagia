<?php

namespace App\Http\Controllers\Dashboards;

use App\Charts\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Contract\MonthlyPayment;
use App\Models\Tution\LowerMonthlyFee;
use Illuminate\Http\Request;

class DashboardsController extends Controller
{

    public function __construct(LowerMonthlyFee $LowerMonthlyFee, MonthlyPayment $MonthlyPayment)
    {
        $this->LowerMonthlyFee = $LowerMonthlyFee;
        $this->MonthlyPayment = $MonthlyPayment;
    }

    public function dashboard(Request $request){

        $total_receivable = $this->MonthlyPayment->where('id_monthly_status', '<>', 'C')->sum('total_payable');
        $total_paid = $this->MonthlyPayment->where('id_monthly_status', '<>', 'C')->sum('amount_paid');
        $total_received = $this->MonthlyPayment->where('id_monthly_status', '<>', 'C')->sum('balance_value');

        $money = $this->LowerMonthlyFee->where('id_type_payment', '=', 'D')->sum('amount_paid');
        $pix = $this->LowerMonthlyFee->where('id_type_payment', '=', 'P')->sum('amount_paid');
        $debit_card = $this->LowerMonthlyFee->where('id_type_payment', '=', 'CD')->sum('amount_paid');
        $credit_card = $this->LowerMonthlyFee->where('id_type_payment', '=', 'CC')->sum('amount_paid');

        $dashboard = new Dashboard;

        $dashboard->labels(['Pix', 'Dinheiro', 'Cartão Débito','Cartão Crédito' ]);

        $dashboard->dataset('Valores Recebidos', 'bar', [$pix,$money,$debit_card,$credit_card])->backgroundColor(['#227093','#218c74','#84817a','#2c2c54']);

        return view('dashboards.dashboard', compact(['dashboard', 'pix', 'money','debit_card','credit_card','total_receivable', 'total_paid', 'total_received']));
    }
}
