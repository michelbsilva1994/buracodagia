<?php

namespace App\Http\Controllers;

use App\Models\Contract\Contract;
use App\Models\Contract\ContractStore;
use App\Models\Contract\MonthlyPayment;
use Illuminate\Http\Request;

class MonthlyPaymentController extends Controller
{

    public function __construct(MonthlyPayment $monthlyPayment, Contract $contract, ContractStore $contractStore)
    {
        $this->monthlyPayment = $monthlyPayment;
        $this->contract = $contract;
        $this->contractStore = $contractStore;

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
        return view('monthlyPayment.tuition', compact('tuition'));
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
            return view('monthlyPayment.tuition', compact('tuition'));
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
            $monthlyPayment->total_payable = $price_store;
            $monthlyPayment->id_contract = $contract->id;

            $monthlyPayment->create([
                'due_date' => $monthlyPayment->due_date,
                'dt_payday' => $monthlyPayment->dt_payday,
                'dt_cancellation' => $monthlyPayment->dt_cancellation,
                'total_payable' => $monthlyPayment->total_payable,
                'id_contract' => $monthlyPayment->id_contract
            ]);
        }

        return redirect()->route('monthly.index')->with('status', 'Mensalidades do vencimento '.$monthlyPayment->due_date.' foram geradas com sucesso!');
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

    public function MonthlyPaymentContract($id_contract){
        $monthlyPayment = $this->monthlyPayment->where('id_contract', '=', $id_contract)->get();

        return view('monthlyPayment.monthlyPaymentContract', compact('monthlyPayment'));
    }
}
