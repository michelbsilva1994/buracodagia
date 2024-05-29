<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\ContractRequest;
use App\Http\Requests\Contract\ContractStoreRequest;
use App\Models\Contract\Contract;
use App\Models\Contract\ContractStore;
use App\Models\Domain\ContractCancellationType;
use App\Models\Domain\TypeContract;
use App\Models\People\LegalPerson;
use App\Models\People\PhysicalPerson;
use App\Models\Structure\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    public function __construct(Contract $contract, PhysicalPerson $physicalPerson,
                                LegalPerson $legalPerson, TypeContract $typeContract, Store $store,
                                ContractStore $contractStore, ContractCancellationType $contractCancellationType)
    {
        $this->contract = $contract;
        $this->physicalPerson = $physicalPerson;
        $this->legalPerson = $legalPerson;
        $this->typeContract = $typeContract;
        $this->store = $store;
        $this->contractStore = $contractStore;
        $this->contractCancellationType = $contractCancellationType;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('view_contract')) {
            return redirect()->route('dashboard')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $name_contractor = $request->name_contractor;

        $cpf = $request->cpf;
        $cpf = str_replace('.','',$cpf);
        $cpf = str_replace('-','',$cpf);

        $query = DB::table('contracts');

        if($name_contractor && $cpf){
            $query->where('name_contractor', 'like', "%$name_contractor%")->where('cpf', 'like', "%$cpf%");
        }
        if($name_contractor){
            $query->where('name_contractor', 'like', "%$name_contractor%");
        }
        if($cpf){
            $query->where('cpf', 'like', "%$cpf%");
        }else{
            $query;
        }

        $contracts = $query->paginate(10);

        return view('contract.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_contract')) {
            return redirect()->route('contract.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $physicalPerson = $this->physicalPerson->all();
        $legalPerson = $this->legalPerson->all();
        $typeContracts = $this->typeContract->where('status', 'A')->get();
        try {
            return view('contract.create', compact(['physicalPerson', 'legalPerson','typeContracts']));
        } catch (\Throwable $th) {
            return redirect()->route('contract.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('store_contract')) {
            return redirect()->route('contract.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $contract = $this->contract;

            if($request->type_person === 'PF'){
                $physicalPerson = $this->physicalPerson->where('id', $request->id_person)->first();

                $contract->type_person = $request->type_person;
                $contract->type_contract = $request->type_contract;
                $contract->cpf = $physicalPerson->cpf;
                $contract->name_contractor = $physicalPerson->name;
                $contract->dt_contraction = $request->dt_contraction;
                $contract->dt_renovation = null;
                $contract->dt_finalization = null;
                $contract->dt_cancellation = null;
                $contract->dt_signature = null;
                $contract->id_physical_person = $physicalPerson->id;
                $contract->id_legal_person = null;
                $contract->create_user = Auth::user()->name;
                $contract->update_user = null;

                $contract->save();

                return redirect()->route('contract.show', $contract->id)->with('status','Contrato Cadastrado com sucesso!');
            }

            if($request->type_person === 'PJ'){
                $legalPerson = $this->legalPerson->where('id', $request->id_person)->first();

                $contract->type_person = $request->type_person;
                $contract->type_contract = $request->type_contract;
                $contract->cnpj = $legalPerson->cnpj;
                $contract->name_contractor = $legalPerson->fantasy_name;
                $contract->dt_contraction = $request->dt_contraction;
                $contract->dt_renovation = null;
                $contract->dt_finalization = null;
                $contract->dt_cancellation = null;
                $contract->dt_signature = null;
                $contract->id_physical_person = null;
                $contract->id_legal_person = $legalPerson->id;
                $contract->create_user = Auth::user()->name;
                $contract->update_user = null;

                $contract->save();

                return redirect()->route('contract.show', $contract->id)->with('status','Contrato Cadastrado com sucesso!');
            }
        } catch (\Throwable $th) {
                return redirect()->route('contract.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Auth::user()->hasPermissionTo('show_contract')) {
            return redirect()->route('contract.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $contract = $this->contract->where('id',$id)->first();
        $stores = $this->store->where('status','<>', 'O')->get();
        $contractStore = $this->store->join('contract_stores','stores.id', 'contract_stores.id_store')->where('contract_stores.id_contract',$contract->id)->get();

        $contractCancellationType = $this->contractCancellationType->where('status', '=', 'A')->get();
        return view('contract.show', compact(['contract', 'stores', 'contractStore','contractCancellationType']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::user()->hasPermissionTo('edit_contract')) {
            return redirect()->route('contract.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $contract = $this->contract->where('id', $id)->first();
            $physicalPerson = $this->physicalPerson->all();
            $legalPerson = $this->legalPerson->all();
            $typeContracts = $this->typeContract->where('status', 'A')->get();
            $contractStore = $this->contractStore->where('id_contract', $contract->id)->count();

            if(empty($contract->dt_signature )){
                if($contractStore === 0){
                    return view('contract.edit', compact(['contract','physicalPerson','legalPerson','typeContracts']));
                }else{
                    return redirect()->route('contract.index')->with('alert', 'O contrato nº: '.$contract->id.' tem lojas vínculada, por favor remover!');
                }
            }else{
                return redirect()->route('contract.index')->with('alert', 'Não foi possível alterar o contrato nº: '.$contract->id.' , pois o contrato já está assinado!');
            }
        } catch (\Throwable $th) {
            return redirect()->route('contract.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContractRequest $request, string $id)
    {
        if (!Auth::user()->hasPermissionTo('update_contract')) {
            return redirect()->route('contract.edit', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $contract = $this->contract->findorfail($id);

            if($request->type_person === 'PF'){
                $physicalPerson = $this->physicalPerson->where('id', $request->id_person)->first();

                $contract->type_person = $request->type_person;
                $contract->type_contract = $request->type_contract;
                $contract->cpf = $physicalPerson->cpf;
                $contract->name_contractor = $physicalPerson->name;
                $contract->dt_contraction = $request->dt_contraction;
                $contract->dt_renovation = null;
                $contract->dt_finalization = null;
                $contract->dt_cancellation = null;
                $contract->dt_signature = null;
                $contract->id_physical_person = $physicalPerson->id;
                $contract->id_legal_person = null;
                $contract->update_user = Auth::user()->name;

                $contract->save();

                return redirect()->route('contract.show', $contract->id)->with('status','Contrato nº: '.$contract->id.' cadastrado com sucesso!');
            }

            if($request->type_person === 'PJ'){
                $legalPerson = $this->legalPerson->where('id', $request->id_person)->first();

                $contract->type_person = $request->type_person;
                $contract->type_contract = $request->type_contract;
                $contract->cnpj = $legalPerson->cnpj;
                $contract->name_contractor = $legalPerson->fantasy_name;
                $contract->dt_contraction = $request->dt_contraction;
                $contract->dt_renovation = null;
                $contract->dt_finalization = null;
                $contract->dt_cancellation = null;
                $contract->dt_signature = null;
                $contract->id_physical_person = null;
                $contract->id_legal_person = $legalPerson->id;
                $contract->update_user = Auth::user()->name;

                $contract->save();

                return redirect()->route('contract.show', $contract->id)->with('status','Contrato nº: '.$contract->id.' alterado com sucesso!');
            }
        } catch (\Throwable $th) {
            return redirect()->route('contract.edit', $contract->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->hasPermissionTo('destroy_contract')) {
            return response()->json(['linked'=> 'Sem permissão para realizar a ação, procure o administrador do sistema!']);
        }

        try {
            $contract = $this->contract->where('id', $id)->first();
            $contractStore = $this->contractStore->where('id_contract', $contract->id)->count();
            if(empty($contract->dt_signature )){
                if($contractStore === 0){
                    $contract->delete();
                    return response()->json(['status' => 'O contrato foi excluído com sucesso!']);
                    //return redirect()->route('contract.index')->with('status', 'O contrato nº: '.$contract->id.' foi excluído com sucesso!');
                }else{
                    return response()->json(['linked' => 'O contrato tem lojas vínculada, por favor remover!']);
                    //return redirect()->route('contract.index')->with('alert', 'O contrato nº: '.$contract->id.' tem lojas vínculada, por favor remover!');
                }
            }else{
                return response()->json(['sign' => 'Não foi possível excluir o contrato, pois o contrato já está assinado!']);
                //return redirect()->route('contract.index')->with('alert', 'Não foi possível excluir o contrato nº: '.$contract->id.' , pois o contrato já está assinado!');
            }

        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
            //return redirect()->route('contract.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }

    }

    public function signContract(string $contract){
        if (!Auth::user()->hasPermissionTo('sing_contract')) {
            return redirect()->route('contract.edit', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $contract = $this->contract->where('id', $contract)->first();
            $total_price_store = $this->contractStore->where('id_contract', $contract->id)->sum('store_price');

            if(empty($contract->dt_signature)){
                $contract->dt_signature = date('Y/m/d');
                $contract->total_price = $total_price_store;
                $contract->update_user = Auth::user()->name;
                $contract->save();
                return redirect()->route('contract.show', $contract)->with('status', 'Contrato assinado com sucesso!');
            }else{
                return redirect()->route('contract.show', $contract)->with('alert', 'Contrato já assinado!');
            }
        } catch (\Throwable $th) {
            return redirect()->route('contract.show', $contract)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    public function reverseContractSignature(string $contract){
        if (!Auth::user()->hasPermissionTo('reverse_contract_signature')) {
            return redirect()->route('contract.edit', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $contract = $this->contract->where('id', $contract)->first();

            if(($contract->dt_signature)){
                $contract->dt_signature = null;
                $contract->total_price = null;
                $contract->update_user = Auth::user()->name;
                $contract->save();
                return redirect()->route('contract.show', $contract)->with('status', 'Assinatura do contrato estornada com sucesso!');
            }else{
                return redirect()->route('contract.show', $contract)->with('alert', 'Contrato sem assinatura!');
            }
        } catch (\Throwable $th) {
            return redirect()->route('contract.show', $contract)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    public function contractStore(ContractStoreRequest $request, $contract){

        if (!Auth::user()->hasPermissionTo('contract_store_contract')) {
            return redirect()->route('contract.show', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $contractStore = $this->contractStore;

            if(empty($contract->dt_signature)){
                $contractStore->id_store = $request->id_store;
                $contractStore->id_contract = $contract;
                $contractStore->store_price = $request->store_price;
                $contractStore->create_user = Auth::user()->name;
                $contractStore->save();

                $store = $this->store->where('id',$request->id_store)->first();
                $store->status = 'O';
                $store->update_user = Auth::user()->name;
                $store->save();

                $total_price_store = $this->contractStore->where('id_contract', $contract)->sum('store_price');

                $contract = $this->contract->where('id',$contract)->first();
                $contract->total_price = $total_price_store;
                $contract->save();

                return redirect()->route('contract.show', $contract)->with('status', 'Loja adicionada com sucesso!');
            }else{
                return redirect()->route('contract.show', $contract)->with('alert', 'Não foi possível adicionar a loja, pois o contrato já está assinado!');
            }
        } catch (\Throwable $th) {
                return redirect()->route('contract.show', $contract)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    public function contractRemoveStore($contractRemoveStore){

        if (!Auth::user()->hasPermissionTo('contract_remove_store_contract')) {
            return response()->json(['status'=> 'Sem permissão para realizar a ação, procure o administrador do sistema!']);
        }

        try {
            $contractStore = $this->contractStore->where('id', $contractRemoveStore)->first();
            $contract = $this->contract->where('id', $contractStore->id_contract)->first();

            if(empty($contract->dt_signature)){
                $contractStore->delete();

                $store = $this->store->where('id', $contractStore->id_store)->first();
                $store->status = 'L';
                $store->update_user = Auth::user()->name;
                $store->save();

                $total_price_store = $this->contractStore->where('id_contract', $contract->id)->sum('store_price');
                $contract->total_price = $total_price_store;
                $contract->save();

                return response()->json(['status' => 'Loja removida do contrato!']);
                //return redirect()->route('contract.show', $contractStore->id_contract)->with('status','Loja removida do contrato!');
            }else{
                return response()->json(['status' => 'Não foi possível remover a loja, pois o contrato já está assinado!']);
                //return redirect()->route('contract.show', $contract->id)->with('error', 'Não foi possível remover a loja, pois o contrato já está assinado!');
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
            //return redirect()->route('contract.show', $contract)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    public function cancelContract(Request $request, $contract){

        try {
            $contractCancellationType = $this->contractCancellationType->where('value', '=', $request->id_cancellation)->first();
            $contract = $this->contract->where('id', $contract)->first();
            $contractStore = $this->contractStore->where('id_contract','=', $contract->id)->get();

            if(!empty($contract->dt_signature) && empty($contract->dt_cancellation)){
                $contract->dt_cancellation = date('Y/m/d');
                $contract->ds_cancellation_reason = $contractCancellationType->description;
                $contract->update_user = Auth::user()->name;
                $contract->save();
            }

        foreach($contractStore as $store){
            $store = $this->store->where('id', '=', $store->id_store)->first();
            $store->status = 'L';
            $store->update_user = Auth::user()->name;
            $store->save();
        }

        return redirect()->route('contract.show',$contract->id)->with('status', 'Contrato cancelado com sucesso!');

        } catch (\Throwable $th) {
            return redirect()->route('contract.show',$contract)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }
}
