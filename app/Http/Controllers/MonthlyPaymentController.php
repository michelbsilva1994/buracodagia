<?php

namespace App\Http\Controllers;

use App\Models\Contract\Contract;
use App\Models\Contract\ContractStore;
use App\Models\Contract\MonthlyPayment;
use App\Models\Domain\TypeCancellation;
use App\Models\Domain\TypePayment;
use App\Models\Structure\Pavement;
use App\Models\Tution\LowerMonthlyFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonthlyPaymentController extends Controller
{

    public function __construct(MonthlyPayment $monthlyPayment, Contract $contract, ContractStore $contractStore,
    TypePayment $typePayment, TypeCancellation $typeCancellation, LowerMonthlyFee $lowerMonthlyFee, Pavement $pavement)
    {
        $this->monthlyPayment = $monthlyPayment;
        $this->contract = $contract;
        $this->contractStore = $contractStore;
        $this->typePayment = $typePayment;
        $this->typeCancellation = $typeCancellation;
        $this->lowerMonthlyFee = $lowerMonthlyFee;
        $this->pavement = $pavement;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('view_monthly_payment')) {
            return redirect()->route('dashboard')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        return view('monthlyPayment.index');
    }

    public function tuition(){

        if (!Auth::user()->hasPermissionTo('view_tution')) {
            return redirect()->route('dashboard')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $tuition = DB::table('contracts')
                    ->selectRaw('contracts.name_contractor,
                    monthly_payments.id,
                    monthly_payments.due_date,
                    monthly_payments.total_payable,
                    monthly_payments.amount_paid,
                    monthly_payments.balance_value,
                    monthly_payments.id_monthly_status,
                    GROUP_CONCAT(stores.name) as stores,
                    pavements.name as pavements'
                    )
                    ->rightJoin('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                    ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                    ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                    ->leftJoin('pavements', 'stores.id_pavement', '=', 'pavements.id')
                    ->groupByRaw('monthly_payments.id, pavements.name')
                    ->orderBy('contracts.name_contractor', 'asc')
                    ->paginate(10);

        $typesPayments = $this->typePayment->where('status', 'A')->get();
        $typesCancellations = $this->typeCancellation->where('status', 'A')->get();
        $pavements = $this->pavement->where('status', 'A')->get();

        return view('monthlyPayment.tuition', compact(['tuition', 'typesPayments', 'typesCancellations','pavements']));
    }

    public function filter(Request $request){

        if (!Auth::user()->hasPermissionTo('view_tution')) {
            return redirect()->route('dashboard')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }


        $typesPayments = $this->typePayment->where('status', 'A')->get();
        $typesCancellations = $this->typeCancellation->where('status', 'A')->get();
        $pavements = $this->pavement->where('status', 'A')->get();

        $contractor = $request->contractor;
        $due_date = $request->due_date;
        $store = $request->store;
        $pavement = $request->pavement;

        $query = DB::table('contracts')
                    ->selectRaw('contracts.name_contractor,
                    monthly_payments.id,
                    monthly_payments.due_date,
                    monthly_payments.total_payable,
                    monthly_payments.amount_paid,
                    monthly_payments.balance_value,
                    monthly_payments.id_monthly_status,
                    GROUP_CONCAT(stores.name) as stores,
                    pavements.name as pavements'
                    )
                    ->rightJoin('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                    ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                    ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                    ->leftJoin('pavements', 'stores.id_pavement', '=', 'pavements.id')
                    ->groupByRaw('monthly_payments.id, pavements.name')
                    ->orderBy('contracts.name_contractor', 'asc');

        if($contractor){
            $query->where('contracts.name_contractor', 'like', "%$contractor%");
        }
        if($due_date){
            $query->where('monthly_payments.due_date', $due_date);
        }
        if($store){
            $query->where('stores.name', 'like', "%$store%");
        }
        if($pavement){
            $query->where('pavements.id',$pavement);
        }

        $tuition = $query->paginate(10);

        return view('monthlyPayment.tuition', compact(['tuition', 'typesPayments', 'typesCancellations', 'pavements']));

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
        if (!Auth::user()->hasPermissionTo('store_monthly_payment')) {
            return redirect()->route('monthly.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        /**pegando todos os contratos assinados e não cancelados*/
        $contracts = $this->contract->whereNotNull('dt_signature')
                                    ->whereNull('dt_cancellation')
                                    ->whereNull('ds_cancellation_reason')
                                    ->get();

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
                            'id_contract' => $monthlyPayment->id_contract,
                            'create_user' => Auth::user()->name,
                            'update_user' => null
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

        if (!Auth::user()->hasPermissionTo('monthly_payment_contract')) {
            return redirect()->route('physical.contractPerson', $id_contract)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $typesPayments = $this->typePayment->where('status', 'A')->get();
        $typesCancellations = $this->typeCancellation->where('status', 'A')->get();
        $contract = $this->contract->where('id', $id_contract)->first();
        $monthlyPayment = $this->monthlyPayment->where('id_contract', '=', $id_contract)->orderBy('due_date', 'desc')->get();

        return view('monthlyPayment.monthlyPaymentContract', compact(['monthlyPayment', 'contract','typesPayments','typesCancellations']));
    }

    public function lowerMonthlyFee(Request $request){
        if (!Auth::user()->hasPermissionTo('lower_monthly_payment')) {
            return redirect()->route('monthly.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $monthlyPayment = $this->monthlyPayment->where('id', $request->id_monthly)->first();
            $typePayment = $this->typePayment->where('value', $request->id_payment)->where('status','A')->first();

            $amount_paid = str_replace(',','.', $request->amount_paid);
            // dd(doubleval($amount_paid));

            if($monthlyPayment->id_monthly_status === 'A' || $monthlyPayment->id_monthly_status === 'P'){
                if($monthlyPayment->balance_value >= $amount_paid){
                    $lowerMonthlyFee = $this->lowerMonthlyFee;

                    $lowerMonthlyFee->create([
                        'amount_paid' => $amount_paid,
                        'id_type_payment' => $typePayment->value,
                        'type_payment' => $typePayment->description,
                        'id_chargeback_low' => null,
                        'chargeback_low' => null,
                        'dt_payday' => $request->dt_payday,
                        'dt_chargeback' => null,
                        'download_user' => Auth()->user()->name,
                        'chargeback_user' => null,
                        'id_monthly_payment' => $monthlyPayment->id,
                        'create_user' => Auth::user()->name,
                        'update_user' => null
                    ]);

                    $balance = $monthlyPayment->balance_value - $amount_paid;

                    if($balance > 0){
                        $monthlyPayment->amount_paid = $monthlyPayment->amount_paid + $amount_paid;
                        $monthlyPayment->balance_value = $balance;
                        $monthlyPayment->id_monthly_status = 'P';
                        $monthlyPayment->monthly_status = 'Parcial';
                        $monthlyPayment->download_user = Auth::user()->name;
                        $monthlyPayment->update_user = Auth::user()->name;
                        $monthlyPayment->save();
                    }
                    if($balance === 0.0 ){
                        $monthlyPayment->dt_payday = $request->dt_payday;
                        $monthlyPayment->amount_paid = $monthlyPayment->amount_paid + $amount_paid;
                        $monthlyPayment->balance_value = $balance;
                        $monthlyPayment->id_monthly_status = 'F';
                        $monthlyPayment->monthly_status = 'Fechado';
                        $monthlyPayment->download_user = Auth::user()->name;
                        $monthlyPayment->update_user = Auth::user()->name;
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
        if (!Auth::user()->hasPermissionTo('cancel_monthly_payment')) {
            return redirect()->route('monthly.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $monthlyPayment = $this->monthlyPayment->where('id', $request->id_monthly_cancel)->first();
            $typeCancellation = $this->typeCancellation->where('value',$request->id_cancellation)->where('status', 'A')->first();

            if($monthlyPayment->id_monthly_status === 'A'){
                $monthlyPayment->dt_cancellation = $request->dt_cancellation;
                $monthlyPayment->id_type_cancellation = $typeCancellation->value;
                $monthlyPayment->type_cancellation = $typeCancellation->description;
                $monthlyPayment->id_monthly_status = 'C';
                $monthlyPayment->monthly_status = 'Cancelada';
                $monthlyPayment->cancellation_user = Auth::user()->name;
                $monthlyPayment->update_user = Auth::user()->name;
                $monthlyPayment->save();
            }

            return redirect()->route('monthly.tuition')->with('status','Mensalidade: '.$monthlyPayment->id.' cancelada com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('monthly.tuition')->with('error','Ops, ocorreu um erro'.$th);
        }
    }

    public function lowerMonthlyFeeContract(Request $request){
        if (!Auth::user()->hasPermissionTo('lower_monthly_payment')) {
            return redirect()->route('monthly.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

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
                        'id_monthly_payment' => $monthlyPayment->id,
                        'create_user' => Auth::user()->name,
                        'update_user' => null
                    ]);

                    $balance = $monthlyPayment->balance_value - $request->amount_paid;

                    if($balance > 0){
                        $monthlyPayment->amount_paid = $monthlyPayment->amount_paid + $request->amount_paid;
                        $monthlyPayment->balance_value = $balance;
                        $monthlyPayment->id_monthly_status = 'P';
                        $monthlyPayment->monthly_status = 'Parcial';
                        $monthlyPayment->download_user = Auth::user()->name;
                        $monthlyPayment->update_user = Auth::user()->name;
                        $monthlyPayment->save();
                    }
                    if($balance === 0.0 ){
                        $monthlyPayment->dt_payday = $request->dt_payday;
                        $monthlyPayment->amount_paid = $monthlyPayment->amount_paid + $request->amount_paid;
                        $monthlyPayment->balance_value = $balance;
                        $monthlyPayment->id_monthly_status = 'F';
                        $monthlyPayment->monthly_status = 'Fechado';
                        $monthlyPayment->download_user = Auth::user()->name;
                        $monthlyPayment->update_user = Auth::user()->name;
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
        if (!Auth::user()->hasPermissionTo('cancel_monthly_payment')) {
            return redirect()->route('monthly.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $monthlyPayment = $this->monthlyPayment->where('id', $request->id_monthly_cancel)->first();
            $typeCancellation = $this->typeCancellation->where('value',$request->id_cancellation)->where('status', 'A')->first();

            if($monthlyPayment->id_monthly_status === 'A'){
                $monthlyPayment->dt_cancellation = $request->dt_cancellation;
                $monthlyPayment->id_type_cancellation = $typeCancellation->value;
                $monthlyPayment->type_cancellation = $typeCancellation->description;
                $monthlyPayment->id_monthly_status = 'C';
                $monthlyPayment->monthly_status = 'Cancelada';
                $monthlyPayment->cancellation_user = Auth::user()->name;
                $monthlyPayment->update_user = Auth::user()->name;
                $monthlyPayment->save();
            }

        return redirect()->route('monthly.MonthlyPaymentContract', $monthlyPayment->id_contract)->with('status','Mensalidade: '.$monthlyPayment->id.' cancelada com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('monthly.MonthlyPaymentContract', $monthlyPayment->id_contract)->with('error','Ops, ocorreu um erro'.$th);
        }
    }
}
