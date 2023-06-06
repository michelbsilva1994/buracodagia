<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Contract\Contract;
use App\Models\People\LegalPerson;
use App\Models\People\PhysicalPerson;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function __construct(Contract $contract, PhysicalPerson $physicalPerson, LegalPerson $legalPerson)
    {
        $this->contract = $contract;
        $this->physicalPerson = $physicalPerson;
        $this->legalPerson = $legalPerson;
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
        try {
            return view('contract.create', compact(['physicalPerson', 'legalPerson']));
        } catch (\Throwable $th) {
            return redirect()->route('contract.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->type_person === 'PF'){
            $physicalPerson = $this->physicalPerson->where('id', $request->id_physical_person)->first();
        }
        if($request->type_person === 'PJ'){
            $legalPerson = $this->legalPerson->where('id', $request->id_legal_person)->first();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
