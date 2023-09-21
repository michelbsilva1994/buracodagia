<?php

namespace App\Http\Controllers;

use App\Models\Contract\Contract;
use App\Models\Contract\ContractStore;
use App\Models\Contract\MonthlyPayment;
use App\Models\Domain\TypeCancellation;
use App\Models\Domain\TypePayment;
use Illuminate\Http\Request;

class MonthlyPaymentController extends Controller
{

    public function __construct(MonthlyPayment $monthlyPayment, Contract $contract, ContractStore $contractStore, TypePayment $typePayment, TypeCancellation $typeCancellation)
    {
        $this->monthlyPayment = $monthlyPayment;
        $this->contract = $contract;
        $this->contractStore = $contractStore;
        $this->typePayment = $typePayment;
        $this->typeCancellation = $typeCancellation;
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
            return view('monthlyPayment.tuition', compact('tuition'));
        }elseif($contractor){
            $tuition = $this->contract
                        ->join('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                        ->where('name_contractor', 'like', "%$contractor%")
                        ->get();
            return view('monthlyPayment.tuition', compact('tuition'));
        }elseif($due_date){
            $tuition = $this->contract
                        ->join('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                        ->where('due_date', $due_date)
                        ->get();
            return view('monthlyPayment.tuition', compact('tuition'));
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
        foreach ($contracts as $contract) {
            $price_store = $this->contractStore->where('id_contract', $contract->id)->sum('store_price');

            $monthlyPayment = $this->monthlyPayment;

            $monthlyPayment->due_date = $request->due_date;
            $monthlyPayment->dt_payday = null;
            $monthlyPayment->dt_cancellation = null;
            $monthlyPayment->fine_value = 0;
            $monthlyPayment->interest_amount = 0;
            $monthlyPayment->discount_value = 0;
            $monthlyPayment->total_payable = $price_store;
            $monthlyPayment->id_type_payment = null;
            $monthlyPayment->type_payment = null;
            $monthlyPayment->id_type_cancellation = null;
            $monthlyPayment->type_cancellation = null;
            $monthlyPayment->id_contract = $contract->id;

            $monthlyPayment->create([
                'due_date' => $monthlyPayment->due_date,
                'dt_payday' => $monthlyPayment->dt_payday,
                'dt_cancellation' => $monthlyPayment->dt_cancellation,
                'fine_value' => $monthlyPayment->fine_value,
                'interest_amount' => $monthlyPayment->interest_amount,
                'discount_value' => $monthlyPayment->discount_value,
                'total_payable' => $monthlyPayment->total_payable,
                'id_type_payment' =>$monthlyPayment->id_type_payment,
                'type_payment' => $monthlyPayment->type_payment,
                'id_contract' => $monthlyPayment->id_contract
            ]);
        }

        return redirect()->route('monthly.index')->with('status', 'Mensalidades do vencimento '.date('d/m/Y', strtotime($monthlyPayment->due_date)).' foram geradas com sucesso!');
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
        $physicalPerson = $this->contract->where('id', $id_contract)->first();
        $monthlyPayment = $this->monthlyPayment->where('id_contract', '=', $id_contract)->get();

        return view('monthlyPayment.monthlyPaymentContract', compact(['monthlyPayment', 'physicalPerson']));
    }

    public function lowerMonthlyFee(Request $request){
        try {
            $monthlyPayment = $this->monthlyPayment->where('id', $request->id_monthly)->first();
            $typePayment = $this->typePayment->where('value', $request->id_payment)->where('status','A')->first();

            if(empty($monthlyPayment->dt_payday) && empty($monthlyPayment->dt_cancellation)){
                $monthlyPayment->dt_payday = $request->dt_payday;
                $monthlyPayment->id_type_payment = $typePayment->value;
                $monthlyPayment->type_payment = $typePayment->description;
                $monthlyPayment->save();
            }
            return redirect()->route('monthly.tuition')->with('status','Baixa da mensalidade: '.$monthlyPayment->id.' realizada com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('monthly.tuition')->with('error','Ops, ocorreu um erro'.$th);
        }
    }

    public function cancelTuition(Request $request){
        $monthlyPayment = $this->monthlyPayment->where('id', $request->id_monthly_cancel)->first();
        $typeCancellation = $this->typeCancellation->where('value',$request->id_cancellation)->where('status', 'A')->first();

        if(empty($monthlyPayment->dt_payday) && empty($monthlyPayment->dt_cancellation)){
            $monthlyPayment->dt_cancellation = $request->dt_cancellation;
            $monthlyPayment->id_type_cancellation = $typeCancellation->value;
            $monthlyPayment->type_cancellation = $typeCancellation->description;
            $monthlyPayment->save();
        }

        return redirect()->route('monthly.tuition')->with('status','Mensalidade: '.$monthlyPayment->id.' cancelada com sucesso!');
    }

    public function lowerMonthlyFeeContract($MonthlyPayment){
        $monthlyPayment = $this->monthlyPayment->where('id', $MonthlyPayment)->first();
        $monthlyPayment->dt_payday = date('Y/m/d');
        $monthlyPayment->save();

        return redirect()->route('monthly.MonthlyPaymentContract', $monthlyPayment->id_contract)->with('status','Baixa da mensalidade: '.$MonthlyPayment.' realizada com sucesso!');
    }

    public function cancelTuitionContract($MonthlyPayment){
        $monthlyPayment = $this->monthlyPayment->where('id', $MonthlyPayment)->first();
        $monthlyPayment->dt_cancellation = date('Y/m/d');
        $monthlyPayment->save();

        return redirect()->route('monthly.MonthlyPaymentContract', $monthlyPayment->id_contract)->with('status','Mensalidade: '.$MonthlyPayment.' cancelada com sucesso!');
    }
}
