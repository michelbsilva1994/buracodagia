<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\TypeContract\TypeContractRequest;
use App\Http\Requests\Domain\TypeContract\TypeContractUpdateRequest;
use App\Models\Domain\TypeContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (!Auth::user()->hasPermissionTo('view_type_contract')) {
            return redirect()->route('services.domainService')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        $typeContracts = $this->typeContract->all();

        return view('domain.type_contract.index', compact('typeContracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_type_contract')) {
            return redirect()->route('typeContract.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
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
        if (!Auth::user()->hasPermissionTo('store_type_contract')) {
            return redirect()->route('typeContract.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $this->typeContract->create([
                'value' => $request->value,
                'description' => $request->description,
                'status' => $request->status,
                'create_user' => Auth::user()->name,
                'update_user' => null
            ]);
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
        if (!Auth::user()->hasPermissionTo('edit_type_contract')) {
            return redirect()->route('typeContract.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
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
        if (!Auth::user()->hasPermissionTo('update_type_contract')) {
            return redirect()->route('typeContract.edit', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $typeContract = $this->typeContract->where('id', $id)->first();

            $typeContract->value = $request->value;
            $typeContract->description = $request->description;
            $typeContract->status = $request->status;
            $typeContract->update_user = Auth::user()->name;

            $typeContract->save();

            return redirect()->route('typeContract.index')->with('status','Tipo de contrato alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('typeContract.edit', $typeContract->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasPermissionTo('destroy_type_contract')) {
            return response()->json(['status'=> 'Sem permissão para realizar a ação, procure o administrador do sistema!']);
        }
        try {
            $typeContract = $this->typeContract->where('id', $id)->first();
            $typeContract->delete();
            return response()->json(['status'=> 'Tipo de contrato excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }

    public function ajaxIndex(){
        $typeContracts = $this->typeContract->all();
        echo json_encode($typeContracts);
    }
}
