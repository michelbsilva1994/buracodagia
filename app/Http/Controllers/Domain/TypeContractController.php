<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\TypeContract\TypeContractRequest;
use App\Http\Requests\Domain\TypeContract\TypeContractUpdateRequest;
use App\Models\Domain\TypeContract;
use Illuminate\Http\Request;

class TypeContractController extends Controller
{
    public function __construct(TypeContract $typeContract)
    {
        $this->typeContract = $typeContract;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeContracts = $this->typeContract->all();
        return view('domain.type_contract.index', compact('typeContracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('domain.type_contract.create');
        } catch (\Throwable $th) {
            return redirect()->route('typeContract.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeContractRequest $request)
    {
        try {
            $this->typeContract->create($request->all());
            return redirect()->route('typeContract.index')->with('status','Tipo de contrato cadastrado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('typeContract.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
        try {
            $typeContract = $this->typeContract->where('id', $id)->first();
            return view('domain.type_contract.edit', compact('typeContract'));
        } catch (\Throwable $th) {
            return redirect()->route('typeContract.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TypeContractUpdateRequest $request, string $id)
    {
        try {
            $typeContract = $this->typeContract->where('id', $id)->first();
            $typeContract->update($request->all());
            return redirect()->route('typeContract.index')->with('status','Tipo de contrato alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('typeContract.edit', $typeContract->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $typeContract = $this->typeContract->where('id', $id)->first();
            $typeContract->delete();
            return redirect()->route('typeContract.index')->with('status','Tipo de contrato excluído com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('typeContract.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }
}
