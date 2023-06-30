<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Contract\Contract;
use App\Models\Contract\ContractStore;
use App\Models\Domain\TypeContract;
use App\Models\People\LegalPerson;
use App\Models\People\PhysicalPerson;
use App\Models\Structure\Store;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function __construct(Contract $contract, PhysicalPerson $physicalPerson,
                                LegalPerson $legalPerson, TypeContract $typeContract, Store $store,
                                ContractStore $contractStore)
    {
        $this->contract = $contract;
        $this->physicalPerson = $physicalPerson;
        $this->legalPerson = $legalPerson;
        $this->typeContract = $typeContract;
        $this->store = $store;
        $this->contractStore = $contractStore;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = $this->contract->all();
        return view('contract.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
    public function store(Request $request)
    {
        try {
            $contract = $this->contract;

            if($request->type_person === 'PF'){
                $physicalPerson = $this->physicalPerson->where('id', $request->id_physical_person)->first();

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

                $contract->save();
                return redirect()->route('contract.index')->with('status','Contrato Cadastrado com sucesso!');
            }

            if($request->type_person === 'PJ'){
                $legalPerson = $this->legalPerson->where('id', $request->id_legal_person)->first();

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

                $contract->save();

                return redirect()->route('contract.index')->with('status','Contrato Cadastrado com sucesso!');
            }
        } catch (\Throwable $th) {
                return redirect()->route('contract.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contract = $this->contract->where('id',$id)->first();
        $stores = $this->store->where('status', 'A')->get();
        $contractStore = $this->contractStore->all();
        return view('contract.show', compact(['contract', 'stores', 'contractStore']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function signContract(string $contract){
        $contract = $this->contract->where('id', $contract)->first();

        $contract->dt_signature = date('Y/m/d');
        $contract->save();

        return redirect()->route('contract.show', $contract)->with('status', 'Contrato assinado com sucesso!');
    }

    public function contractStore(Request $request, $contract){
        $contractStore = $this->contractStore;

        $contractStore->id_store = $request->id_store;
        $contractStore->id_contract = $contract;
        $contractStore->store_price = $request->store_price;

        $contractStore->save();

        $store = $this->store->where('id',$request->id_store)->first();
        $store->status = 'L';
        $store->save();

        return redirect()->route('contract.show', $contract)->with('status', 'Loja adicionada com sucesso!');
    }
}
