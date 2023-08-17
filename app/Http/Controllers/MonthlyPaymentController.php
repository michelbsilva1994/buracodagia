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
}
