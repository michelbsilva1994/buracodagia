<?php

namespace App\Http\Controllers\Dashboards;

use App\Charts\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Contract\MonthlyPayment;
use App\Models\Tution\LowerMonthlyFee;
use Illuminate\Http\Request;

class DashboardsController extends Controller
{

    public function __construct(LowerMonthlyFee $LowerMonthlyFee)
    {
        $this->LowerMonthlyFee = $LowerMonthlyFee;
    }

    public function dashboard(){

        $dinheiro = $this->LowerMonthlyFee->where('id_type_payment', '=', 'D')->sum('amount_paid');
        $pix = $this->LowerMonthlyFee->where('id_type_payment', '=', 'P')->sum('amount_paid');
        $cartao_debito = $this->LowerMonthlyFee->where('id_type_payment', '=', 'CD')->sum('amount_paid');
        $cartao_credito = $this->LowerMonthlyFee->where('id_type_payment', '=', 'CC')->sum('amount_paid');

        $dashboard = new Dashboard;

        $dashboard->labels(['Pix', 'Dinheiro', 'Cartão Débito','Cartão Crédito' ]);

        $dashboard->dataset('Valores Recebidos', 'doughnut', [$pix,$dinheiro,$cartao_debito,$cartao_credito])->backgroundColor(['#2980b9','#2c3e50','#f1c40f','#8e44ad']);

        return view('dashboards.dashboardTeste', compact('dashboard'));
    }
}
