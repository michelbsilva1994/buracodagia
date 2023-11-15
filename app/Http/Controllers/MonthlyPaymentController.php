<?php

namespace App\Http\Controllers;

use App\Models\Contract\Contract;
use App\Models\Contract\ContractStore;
use App\Models\Contract\MonthlyPayment;
use App\Models\Domain\TypeCancellation;
use App\Models\Domain\TypePayment;
use App\Models\Tution\LowerMonthlyFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyPaymentController extends Controller
{

    public function __construct(MonthlyPayment $monthlyPayment, Contract $contract, ContractStore $contractStore,
    TypePayment $typePayment, TypeCancellation $typeCancellation, LowerMonthlyFee $lowerMonthlyFee)
    {
        $this->monthlyPayment = $monthlyPayment;
        $this->contract = $contract;
        $this->contractStore = $contractStore;
        $this->typePayment = $typePayment;
        $this->typeCancellation = $typeCancellation;
        $this->lowerMonthlyFee = $lowerMonthlyFee;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('monthlyPayment.index');
    }

    public function tuition(){
        $tuition = $this->contract
                        ->join('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                        ->get();
        $typesPayments = $this->typePayment->where('status', 'A')->get();
        $typesCancellations = $this->typeCancellation->where('status', 'A')->get();

        return view('monthlyPayment.tuition', compact(['tuition', 'typesPayments', 'typesCancellations']));
    }

    public function filter(Request $request){

        $contractor = $request->contractor;
        $due_date = $request->due_date;

        if($contractor && $due_date) {
            $tuition = $this->contract
                        ->join('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                        ->where('name_contractor', 'like', "%$contractor%")
                        ->where('due_date', $due_date)
                        ->get();
                        $typesPayments = $this->typePayment->where('status', 'A')->get();
                        $typesCancellations = $this->typeCancellation->where('status', 'A')->get();
            return view('monthlyPayment.tuition', compact(['tuition', 'typesPayments', 'typesCancellations']));
        }elseif($contractor){
            $tuition = $this->contract
                        ->join('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                        ->where('name_contractor', 'like', "%$contractor%")
                        ->get();
                        $typesPayments = $this->typePayment->where('status', 'A')->get();
                        $typesCancellations = $this->typeCancellation->where('status', 'A')->get();
            return view('monthlyPayment.tuition', compact(['tuition', 'typesPayments', 'typesCancellations']));
        }elseif($due_date){
            $tuition = $this->contract
                        ->join('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                        ->where('due_date', $due_date)
                        ->get();
                        $typesPayments = $this->typePayment->where('status', 'A')->get();
                        $typesCancellations = $this->typeCancellation->where('status', 'A')->get();
            return view('monthlyPayment.tuition', compact(['tuition', 'typesPayments', 'typesCancellations']));
        }else{
            $tuition = $this->contract
                        ->join('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                        ->get();
            return redirect()->route('monthly.tuition');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**pegando todos os contratos */
        $contracts = $this->contract->all();

        /**Percorrendo todos os contratos para gerar a mensalidade*/
        try {
            if($request->due_date < date('Y-m-d') ){
                return redirect()->route('monthly.index')->with('alert', 'Não é permitida gerar mensalidade em lote com data retroativa!');
            }else{
                foreach ($contracts as $contract) {
                    $price_store = $this->contractStore->where('id_contract', $contract->id)->sum('store_price');
                    $tution = $this->monthlyPayment->where('id_contract', $contract->id)->where('due_date', $request->due_date)->first();

                    $monthlyPayment = $this->monthlyPayment;

                    if(empty($tution)){
                        $monthlyPayment->due_date = $request->due_date;
                        $monthlyPayment->dt_payday = null;
                        $monthlyPayment->dt_cancellation = null;
                        $monthlyPayment->fine_value = 0;
                        $monthlyPayment->interest_amount = 0;
                        $monthlyPayment->discount_value = 0;
                        $monthlyPayment->total_payable = $price_store;
                        $monthlyPayment->amount_paid = 0;
                        $monthlyPayment->balance_value = $price_store;
                        $monthlyPayment->id_monthly_status = 'A';
                        $monthlyPayment->monthly_status = 'Aberto';
                        $monthlyPayment->id_type_cancellation = null;
                        $monthlyPayment->type_cancellation = null;
                        $monthlyPayment->download_user = null;
                        $monthlyPayment->cancellation_user = null;
                        $monthlyPayment->id_contract = $contract->id;

                        $monthlyPayment->create([
                            'due_date' => $monthlyPayment->due_date,
                            'dt_payday' => $monthlyPayment->dt_payday,
                            'dt_cancellation' => $monthlyPayment->dt_cancellation,
                            'fine_value' => $monthlyPayment->fine_value,
                            'interest_amount' => $monthlyPayment->interest_amount,
                            'discount_value' => $monthlyPayment->discount_value,
                            'total_payable' => $monthlyPayment->total_payable,
                            'amount_paid' => $monthlyPayment->amount_paid,
                            'balance_value' => $monthlyPayment->balance_value,
                            'id_monthly_status' => $monthlyPayment->id_monthly_status,
                            'monthly_status' => $monthlyPayment->monthly_status,
                            'id_type_cancellation' => $monthlyPayment->id_type_cancellation,
                            'type_cancellation' => $monthlyPayment->type_cancellation,
                            'download_user' => $monthlyPayment->download_user,
                            'cancellation_user' => $monthlyPayment->cancellation_user,
                            'id_contract' => $monthlyPayment->id_contract
                        ]);
                    }
                }
                return redirect()->route('monthly.index')->with('status', 'Mensalidades do vencimento '.date('d/m/Y', strtotime($request->due_date)).' foram geradas com sucesso!');
            }
        } catch (\Throwable $th) {
                return redirect()->route('monthly.index')->with('error', 'Ops, ocorreu um erro'.$th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MonthlyPayment $monthlyPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MonthlyPayment $monthlyPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MonthlyPayment $monthlyPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MonthlyPayment $monthlyPayment)
    {
        //
    }

    public function monthlyPaymentContract($id_contract){
        $typesPayments = $this->typePayment->where('status', 'A')->get();
        $typesCancellations = $this->typeCancellation->where('status', 'A')->get();
        $contract = $this->contract->where('id', $id_contract)->first();
        $monthlyPayment = $this->monthlyPayment->where('id_contract', '=', $id_contract)->orderBy('due_date', 'desc')->get();

        return view('monthlyPayment.monthlyPaymentContract', compact(['monthlyPayment', 'contract','typesPayments','typesCancellations']));
    }

    public function lowerMonthlyFee(Request $request){
        try {
            $monthlyPayment = $this->monthlyPayment->where('id', $request->id_monthly)->first();
            $typePayment = $this->typePayment->where('value', $request->id_payment)->where('status','A')->first();

            if($monthlyPayment->id_monthly_status === 'A' || $monthlyPayment->id_monthly_status === 'P'){
                if($monthlyPayment->balance_value >= $request->amount_paid){
                    $lowerMonthlyFee = $this->lowerMonthlyFee;

                    $lowerMonthlyFee->create([
                        'amount_paid' => $request->amount_paid,
                        'id_type_payment' => $typePayment->value,
                        'type_payment' => $typePayment->description,
                        'id_chargeback_low' => null,
                        'chargeback_low' => null,
                        'dt_payday' => $request->dt_payday,
                        'dt_chargeback' => null,
                        'download_user' => Auth()->user()->name,
                        'chargeback_user' => null,
                        'id_monthly_payment' => $monthlyPayment->id
                    ]);

                    $balance = $monthlyPayment->balance_value - $request->amount_paid;

                    if($balance > 0){
                        $monthlyPayment->amount_paid = $monthlyPayment->amount_paid + $request->amount_paid;
                        $monthlyPayment->balance_value = $balance;
                        $monthlyPayment->id_monthly_status = 'P';
                        $monthlyPayment->monthly_status = 'Parcial';
                        $monthlyPayment->save();
                    }
                    if($balance === 0.0 ){
                        $monthlyPayment->dt_payday = $request->dt_payday;
                        $monthlyPayment->amount_paid = $monthlyPayment->amount_paid + $request->amount_paid;
                        $monthlyPayment->balance_value = $balance;
                        $monthlyPayment->id_monthly_status = 'F';
                        $monthlyPayment->monthly_status = 'Fechado';
                        $monthlyPayment->download_user = Auth()->user()->name;
                        $monthlyPayment->save();
                    }
                }else{
                    return redirect()->route('monthly.tuition')->with('alert','Valor a receber é maior que valor de saldo!');
                }
            }

            return redirect()->route('monthly.tuition')->with('status','Baixa da mensalidade: '.$monthlyPayment->id.' realizada com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('monthly.tuition')->with('error','Ops, ocorreu um erro'.$th);
        }
    }

    public function cancelTuition(Request $request){
        try {
            $monthlyPayment = $this->monthlyPayment->where('id', $request->id_monthly_cancel)->first();
            $typeCancellation = $this->typeCancellation->where('value',$request->id_cancellation)->where('status', 'A')->first();

            if($monthlyPayment->id_monthly_status === 'A'){
                $monthlyPayment->dt_cancellation = $request->dt_cancellation;
                $monthlyPayment->id_type_cancellation = $typeCancellation->value;
                $monthlyPayment->type_cancellation = $typeCancellation->description;
                $monthlyPayment->id_monthly_status = 'C';
                $monthlyPayment->monthly_status = 'Cancelada';
                $monthlyPayment->cancellation_user = Auth()->user()->name;
                $monthlyPayment->save();
            }

            return redirect()->route('monthly.tuition')->with('status','Mensalidade: '.$monthlyPayment->id.' cancelada com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('monthly.tuition')->with('error','Ops, ocorreu um erro'.$th);
        }
    }

    public function lowerMonthlyFeeContract(Request $request){
        try {
            $monthlyPayment = $this->monthlyPayment->where('id', $request->id_monthly)->first();
            $typePayment = $this->typePayment->where('value', $request->id_payment)->where('status','A')->first();

            if($monthlyPayment->id_monthly_status === 'A' || $monthlyPayment->id_monthly_status === 'P'){
                if($monthlyPayment->balance_value >= $request->amount_paid){
                    $lowerMonthlyFee = $this->lowerMonthlyFee;

                    $lowerMonthlyFee->create([
                        'amount_paid' => $request->amount_paid,
                        'id_type_payment' => $typePayment->value,
                        'type_payment' => $typePayment->description,
                        'id_chargeback_low' => null,
                        'chargeback_low' => null,
                        'dt_payday' => $request->dt_payday,
                        'dt_chargeback' => null,
                        'download_user' => Auth()->user()->name,
                        'chargeback_user' => null,
                        'id_monthly_payment' => $monthlyPayment->id
                    ]);

                    $balance = $monthlyPayment->balance_value - $request->amount_paid;

                    if($balance > 0){
                        $monthlyPayment->amount_paid = $monthlyPayment->amount_paid + $request->amount_paid;
                        $monthlyPayment->balance_value = $balance;
                        $monthlyPayment->id_monthly_status = 'P';
                        $monthlyPayment->monthly_status = 'Parcial';
                        $monthlyPayment->save();
                    }
                    if($balance === 0.0 ){
                        $monthlyPayment->dt_payday = $request->dt_payday;
                        $monthlyPayment->amount_paid = $monthlyPayment->amount_paid + $request->amount_paid;
                        $monthlyPayment->balance_value = $balance;
                        $monthlyPayment->id_monthly_status = 'F';
                        $monthlyPayment->monthly_status = 'Fechado';
                        $monthlyPayment->download_user = Auth()->user()->name;
                        $monthlyPayment->save();
                    }
                }else{
                    return redirect()->route('monthly.tuition')->with('alert','Valor a receber é maior que valor de saldo!');
                }
            }

            return redirect()->route('monthly.MonthlyPaymentContract', $monthlyPayment->id_contract)->with('status','Baixa da mensalidade: '.$monthlyPayment->id.' realizada com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('monthly.MonthlyPaymentContract', $monthlyPayment->id_contract)->with('error','Ops, ocorreu um erro'.$th);
        }
    }

    public function cancelTuitionContract(Request $request){
        try {
            $monthlyPayment = $this->monthlyPayment->where('id', $request->id_monthly_cancel)->first();
            $typeCancellation = $this->typeCancellation->where('value',$request->id_cancellation)->where('status', 'A')->first();

            if($monthlyPayment->id_monthly_status === 'A'){
                $monthlyPayment->dt_cancellation = $request->dt_cancellation;
                $monthlyPayment->id_type_cancellation = $typeCancellation->value;
                $monthlyPayment->type_cancellation = $typeCancellation->description;
                $monthlyPayment->id_monthly_status = 'C';
                $monthlyPayment->monthly_status = 'Cancelada';
                $monthlyPayment->cancellation_user = Auth()->user()->name;
                $monthlyPayment->save();
            }

        return redirect()->route('monthly.MonthlyPaymentContract', $monthlyPayment->id_contract)->with('status','Mensalidade: '.$monthlyPayment->id.' cancelada com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('monthly.MonthlyPaymentContract', $monthlyPayment->id_contract)->with('error','Ops, ocorreu um erro'.$th);
        }
    }
}
