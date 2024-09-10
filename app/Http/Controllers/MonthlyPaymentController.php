<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonthlyPayment\MonthlyPaymentRequest;
use App\Http\Requests\MonthlyPayment\RetroactiveMonthlyFeeRequest;
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
        $pavements = $this->pavement->where('status', 'A')->get();

        if (!Auth::user()->hasPermissionTo('view_monthly_payment')) {
            return redirect()->route('dashboard')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        return view('monthlyPayment.index', compact(['pavements']));
    }

    public function tuition(Request $request){

        if (!Auth::user()->hasPermissionTo('view_tution')) {
            return redirect()->route('dashboard')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $typesPayments = $this->typePayment->where('status', 'A')->get();
        $typesCancellations = $this->typeCancellation->where('status', 'A')->get();
        $pavements = $this->pavement->where('status', 'A')->get();

        $query = DB::table('contracts')
                    ->selectRaw('monthly_payments.id,
                    contracts.name_contractor,
                    monthly_payments.due_date,
                    monthly_payments.total_payable,
                    monthly_payments.amount_paid,
                    monthly_payments.balance_value,
                    monthly_payments.id_monthly_status,
                    GROUP_CONCAT(stores.name) as stores,
                    GROUP_CONCAT(stores.id) as id_stores,
                    GROUP_CONCAT(distinct pavements.name) as pavements'
                    )
                    ->rightJoin('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                    ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                    ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                    ->leftJoin('pavements', 'stores.id_pavement', '=', 'pavements.id')
                    ->where('monthly_payments.id_monthly_status', '<>', 'C')
                    ->groupByRaw('monthly_payments.id')
                    ->orderBy('monthly_payments.due_date', 'desc')
                    ->orderBy('pavements', 'asc')
                    ->orderBy('stores', 'asc');

        $queryTotals = DB::table('contracts')
                    ->selectRaw('sum(monthly_payments.total_payable) as total_payable,
                                 sum(monthly_payments.amount_paid) as amount_paid,
                                 sum(monthly_payments.balance_value) as balance_value')
                    ->rightJoin('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                    ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                    ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                    ->leftJoin('pavements', 'stores.id_pavement', '=', 'pavements.id')
                    ->where('monthly_payments.id_monthly_status', '<>', 'C');

        if(Auth::user()->user_type_service_order === 'U'){
            $query->where('id_physical_person', Auth::user()->id_physical_people);
            $queryTotals->where('id_physical_person', Auth::user()->id_physical_people);
        }
        if($request->contractor){
            $query->where('contracts.name_contractor', 'like', "%$request->contractor%");
            $queryTotals->where('contracts.name_contractor', 'like', "%$request->contractor%");
        }
        if($request->due_date){
            $query->where('monthly_payments.due_date', $request->due_date);
            $queryTotals->where('monthly_payments.due_date', $request->due_date);
        }
        if($request->store){
            $query->where('stores.name', 'like', "%$request->store%");
            $queryTotals->where('stores.name', 'like', "%$request->store%");
        }
        if($request->pavement){
            $query->where('pavements.id',$request->pavement);
            $queryTotals->where('pavements.id',$request->pavement);
        }

        $tuition = $query->paginate(10)->appends($request->input());
        $tuitionTotals = $queryTotals->first();

        if($request->ajax()){
            $view = view('monthlyPayment.tuition_data', compact(['tuition', 'tuitionTotals']))->render();
            $pagination = view('monthlyPayment.pagination', compact('tuition'))->render();
            return response()->json(['html' => $view, 'pagination' => $pagination]);
        }

        return view('monthlyPayment.tuition', compact(['tuition', 'typesPayments', 'typesCancellations','pavements', 'tuitionTotals']));
    }

    public function tuitionAjax(Request $request){

        if (!Auth::user()->hasPermissionTo('view_tution')) {
            return redirect()->route('dashboard')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }


        $typesPayments = $this->typePayment->where('status', 'A')->get();
        $typesCancellations = $this->typeCancellation->where('status', 'A')->get();
        $pavements = $this->pavement->where('status', 'A')->get();

        $query = DB::table('contracts')
                    ->selectRaw('monthly_payments.id,
                    contracts.name_contractor,
                    monthly_payments.due_date,
                    monthly_payments.total_payable,
                    monthly_payments.amount_paid,
                    monthly_payments.balance_value,
                    monthly_payments.id_monthly_status,
                    GROUP_CONCAT(stores.name) as stores,
                    GROUP_CONCAT(stores.id) as id_stores,
                    GROUP_CONCAT(distinct pavements.name) as pavements'
                    )
                    ->rightJoin('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                    ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                    ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                    ->Join('pavements', 'stores.id_pavement', '=', 'pavements.id')
                    ->where('monthly_payments.id_monthly_status', '<>', 'C')
                    ->groupByRaw('monthly_payments.id')
                    ->orderBy('monthly_payments.due_date', 'desc')
                    ->orderBy('pavements', 'asc')
                    ->orderBy('stores', 'asc');

        $queryTotals = DB::table('contracts')
                    ->selectRaw('sum(monthly_payments.total_payable) as total_payable,
                                 sum(monthly_payments.amount_paid) as amount_paid,
                                 sum(monthly_payments.balance_value) as balance_value')
                    ->rightJoin('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                    ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                    ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                    ->leftJoin('pavements', 'stores.id_pavement', '=', 'pavements.id')
                    ->where('monthly_payments.id_monthly_status', '<>', 'C');

        if(Auth::user()->user_type_service_order === 'U'){
            $query->where('id_physical_person', Auth::user()->id_physical_people);
            $queryTotals->where('id_physical_person', Auth::user()->id_physical_people);
        }
        if($request->contractor){
            $query->where('contracts.name_contractor', 'like', "%$request->contractor%");
            $queryTotals->where('contracts.name_contractor', 'like', "%$request->contractor%");
        }
        if($request->due_date){
            $query->where('monthly_payments.due_date', $request->due_date);
            $queryTotals->where('monthly_payments.due_date', $request->due_date);
        }
        if($request->store){
            $query->where('stores.name', 'like', "%$request->store%");
            $queryTotals->where('stores.name', 'like', "%$request->store%");
        }
        if($request->pavement){
            $query->where('pavements.id',$request->pavement);
            $queryTotals->where('pavements.id',$request->pavement);
        }

        $tuition = $query->paginate(10)->appends($request->input());
        $tuitionTotals = $queryTotals->first();

        if($request->ajax()){
            $view = view('monthlyPayment.tuition_data', compact(['tuition', 'tuitionTotals']))->render();
            $pagination = view('monthlyPayment.pagination', compact('tuition'))->render();
            return response()->json(['html' => $view, 'pagination' => $pagination]);
        }

        return view('monthlyPayment.tuition', compact(['tuition', 'typesPayments', 'typesCancellations','pavements','tuitionTotals']));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function createGenerateRetroactiveMonthlyPayment(){
        if (!Auth::user()->hasPermissionTo('generate_retroactive_monthly_payment')) {
            return redirect()->route('monthly.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        $contracts = $this->contract->whereNotNull('dt_signature')
                                    ->whereNull('dt_cancellation')
                                    ->whereNull('ds_cancellation_reason')
                                    ->orderBy('name_contractor')
                                    ->get();
        return view('monthlyPayment.retroactiveMonthlyFeeRequest', compact(['contracts']));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MonthlyPaymentRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('store_monthly_payment')) {
            return redirect()->route('monthly.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        /**pegando todos os contratos assinados e não cancelados*/
        // $contracts = $this->contract->whereNotNull('dt_signature')
        //                             ->whereNull('dt_cancellation')
        //                             ->whereNull('ds_cancellation_reason')
        //                             ->get();

        $query = DB::table('contracts')
                            ->selectRaw('distinct contracts.id')
                            ->join('contract_stores', 'contracts.id', '=', 'contract_stores.id_contract')
                            ->join('stores', 'contract_stores.id_store', '=', 'stores.id')
                            ->whereNotNull('dt_signature')
                            ->whereNull('dt_cancellation')
                            ->whereNull('ds_cancellation_reason');

        if($request->pavement){
            $query->where('stores.id_pavement', '=', $request->pavement);
        }
        if($request->contract){
            $query->where('contracts.id', '=', $request->contract);
        }

        $contracts = $query->get();

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

    public function generateRetroactiveMonthlyPayment(RetroactiveMonthlyFeeRequest $request){
        if (!Auth::user()->hasPermissionTo('generate_retroactive_monthly_payment')) {
            return redirect()->route('monthly.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $query = DB::table('contracts')
                            ->selectRaw('distinct contracts.id')
                            ->join('contract_stores', 'contracts.id', '=', 'contract_stores.id_contract')
                            ->join('stores', 'contract_stores.id_store', '=', 'stores.id')
                            ->whereNotNull('dt_signature')
                            ->whereNull('dt_cancellation')
                            ->whereNull('ds_cancellation_reason')
                            ->where('contracts.id', '=', $request->contract);

        $contract = $query->first();

        try {
            $price_store = $this->contractStore->where('id_contract', $contract->id)->sum('store_price');
            $tution = $this->monthlyPayment->where('id_contract', $contract->id)->where('due_date', $request->due_date)->where('id_monthly_status','<>','C')->first();
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
                return redirect()->route('monthly.createGenerateRetroactiveMonthlyPayment')->with('status', 'Mensalidade do vencimento '.date('d/m/Y', strtotime($request->due_date)).' do contrato - '. $contract->id .' gerada com sucesso!');
            }
            if(($tution)){
                return redirect()->route('monthly.createGenerateRetroactiveMonthlyPayment')->with('alert', 'Já existe mensalidade com o vencimento '.date('d/m/Y', strtotime($request->due_date)).' para o contrato - '. $contract->id .', por gentileza verificar!');
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

    public function monthlyPaymentContract($id_contract, Request $request){

        if (!Auth::user()->hasPermissionTo('monthly_payment_contract')) {
            return redirect()->route('physical.contractPerson', $id_contract)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $typesPayments = $this->typePayment->where('status', 'A')->get();
        $typesCancellations = $this->typeCancellation->where('status', 'A')->get();
        $contract = $this->contract->where('id', $id_contract)->first();

        $query = DB::table('contracts')
                            ->selectRaw('contracts.name_contractor,
                            monthly_payments.id,
                            monthly_payments.due_date,
                            monthly_payments.total_payable,
                            monthly_payments.amount_paid,
                            monthly_payments.balance_value,
                            monthly_payments.id_monthly_status,
                            GROUP_CONCAT(stores.name) as stores,
                            GROUP_CONCAT(stores.id) as id_stores,
                            pavements.name as pavements'
                            )
                            ->rightJoin('monthly_payments', 'contracts.id', '=', 'monthly_payments.id_contract')
                            ->leftJoin('contract_stores','contracts.id', '=', 'contract_stores.id_contract')
                            ->leftJoin('stores', 'contract_stores.id_store', '=', 'stores.id')
                            ->leftJoin('pavements', 'stores.id_pavement', '=', 'pavements.id')
                            ->where('contracts.id','=', $id_contract)
                            ->groupByRaw('monthly_payments.id, pavements.name')
                            ->orderBy('pavements', 'asc')
                            ->orderBy('stores', 'asc');

        if($request->due_date){
            $query->where('monthly_payments.due_date', $request->due_date);
        }

        $tuition = $query->paginate(10)->appends($request->input());

        if($request->ajax()){
            $view = view('monthlyPayment.monthlyPaymentContract.tuition_contract', compact('tuition'))->render();
            $pagination = view('monthlyPayment.monthlyPaymentContract.pagination', compact('tuition'))->render();
            return response()->json(['html' => $view, 'pagination' => $pagination]);
        }

        return view('monthlyPayment.monthlyPaymentContract', compact(['tuition', 'contract','typesPayments','typesCancellations']));
    }

    public function lowerMonthlyFee(Request $request){
        if (!Auth::user()->hasPermissionTo('lower_monthly_payment')) {
            return redirect()->route('monthly.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $monthlyPayment = $this->monthlyPayment->where('id', $request->id_monthly)->first();
            $typePayment = $this->typePayment->where('value', $request->id_payment)->where('status','A')->first();

            //dd($request->amount_paid);

            $amount_paid = str_replace('.','', $request->amount_paid);
            $amount_paid = str_replace(',','.', $amount_paid);
            $amount_paid = doubleval($amount_paid);

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
                        'update_user' => null,
                        'operation_type' => 'B',
                        'id_lower_monthly_fees_reverse' => null,
                        'id_lower_monthly_fees_origin' => null,
                        'description' => null
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
                    return response()->json(['alert' => 'Valor a receber é maior que valor de saldo!']);
                }
            }
            return response()->json(['status' => 'Baixa da mensalidade: '.$monthlyPayment->id.' realizada com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
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

            return response()->json(['status' => 'Mensalidade cancelada com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ops, ocorreu um erro inesperado!']);
        }
    }

    public function view_lower_monthly_fees($id_monthly){
        $lowerMonthlyFees = $this->lowerMonthlyFee->where('id_monthly_payment', $id_monthly)->get();

        return response()->json(['lowers' => $lowerMonthlyFees]);

        // return view('monthlyPayment.lowerMonthly_free.monthly_fee_reductions', compact('lowerMonthlyFees'));
    }

    public function reverse_monthly_payment(Request $request){
        if (!Auth::user()->hasPermissionTo('reverse_monthly_payment')) {
            return redirect()->route('dashboard')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        $lowerMonthlyPayment = $this->lowerMonthlyFee->where('id', $request->id_lowerMonthlyFee)->first();
        $monthlyPayment = $this->monthlyPayment->where('id', $lowerMonthlyPayment->id_monthly_payment)->first();

        // criando baixa de estorno
        try {
            $lowerMonthlyFee = LowerMonthlyFee::create([
                'amount_paid' => -($lowerMonthlyPayment->amount_paid),
                'id_type_payment' => null,
                'type_payment' => null,
                'id_chargeback_low' => null,
                'chargeback_low' => null,
                'dt_payday' => null,
                'dt_chargeback' => Date('Y/m/d'),
                'download_user' => null,
                'chargeback_user' => Auth()->user()->name,
                'id_monthly_payment' => $monthlyPayment->id,
                'create_user' => Auth::user()->name,
                'update_user' => null,
                'operation_type' => 'E',
                'id_lower_monthly_fees_reverse' => null,
                'id_lower_monthly_fees_origin' => $lowerMonthlyPayment->id,
                'description' => null
            ]);
            $lowerMonthlyFee->save;

            //calculando saldo da mensalidade
            $balance = $monthlyPayment->balance_value + $lowerMonthlyPayment->amount_paid;

            //vinculando baixa de estorno a baixa de origem
            $lowerMonthlyPayment->id_lower_monthly_fees_reverse = $lowerMonthlyFee->id;
            $lowerMonthlyPayment->save();

            //atualizando valores e status da mensalidade
            if($balance > 0 && $balance < $monthlyPayment->total_payable){
                $monthlyPayment->amount_paid = $monthlyPayment->amount_paid - $lowerMonthlyPayment->amount_paid;
                $monthlyPayment->balance_value = $balance;
                $monthlyPayment->id_monthly_status = 'P';
                $monthlyPayment->monthly_status = 'Parcial';
                $monthlyPayment->update_user = Auth::user()->name;
                $monthlyPayment->save();
            }
            if($balance === $monthlyPayment->total_payable){
                $monthlyPayment->dt_payday = $request->dt_payday;
                $monthlyPayment->amount_paid = $monthlyPayment->amount_paid - $lowerMonthlyPayment->amount_paid;
                $monthlyPayment->balance_value = $balance;
                $monthlyPayment->id_monthly_status = 'A';
                $monthlyPayment->monthly_status = 'Aberto';
                $monthlyPayment->update_user = Auth::user()->name;
                $monthlyPayment->save();
            }
            return response()->json(['status' => 'Baixa estornada com sucesso!']);
            //return redirect()->route('monthly.lowerMonthlyFeeIndex', $monthlyPayment->id)->with('status', 'Baixa estornada com sucesso!');
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ops, ocorreu um erro inesperado!']);
        }
    }
}
