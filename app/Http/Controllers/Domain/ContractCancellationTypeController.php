<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\ContractCancellationType\ContractCancellationTypeRequest;
use App\Http\Requests\Domain\ContractCancellationType\ContractCancellationTypeUpdateRequest;
use App\Models\Domain\ContractCancellationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractCancellationTypeController extends Controller
{
    public function __construct(ContractCancellationType $ContractCancellationType)
    {
        $this->ContractCancellationType = $ContractCancellationType;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('view_contract_cancellation_type')) {
            return redirect()->route('services.domainService')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        $ContractCancellationType = $this->ContractCancellationType->all();
        return view('domain.contract_cancellation_type.index', compact('ContractCancellationType'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_contract_cancellation_type')) {
            return redirect()->route('contractCancellationType.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            return view('domain.contract_cancellation_type.create');
        } catch (\Throwable $th) {
            return redirect()->route('domain.contract_cancellation_type.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractCancellationTypeRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('store_contract_cancellation_type')) {
            return redirect()->route('contractCancellationType.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $this->ContractCancellationType->create([
                'value' => $request->value,
                'description' => $request->description,
                'status' => $request->status,
                'create_user' => Auth::user()->name,
                'update_user' => null
            ]);
            return redirect()->route('contractCancellationType.index')->with('status','Tipo de cancelamento cadastrado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('contractCancellationType.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
        if (!Auth::user()->hasPermissionTo('edit_contract_cancellation_type')) {
            return redirect()->route('contractCancellationType.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $ContractCancellationType = $this->ContractCancellationType->where('id', $id)->first();
            return view('domain.contract_cancellation_type.edit', compact('ContractCancellationType'));
        } catch (\Throwable $th) {
            return redirect()->route('contractCancellationType.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContractCancellationTypeUpdateRequest $request, string $id)
    {
        if (!Auth::user()->hasPermissionTo('update_contract_cancellation_type')) {
            return redirect()->route('contractCancellationType.edit', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $ContractCancellationType = $this->ContractCancellationType->where('id', $id)->first();

            $ContractCancellationType->value = $request->value;
            $ContractCancellationType->description = $request->description;
            $ContractCancellationType->status = $request->status;
            $ContractCancellationType->update_user = Auth::user()->name;

            $ContractCancellationType->save();

            return redirect()->route('contractCancellationType.index')->with('status','Tipo de cancelamento alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('contractCancellationType.edit', $ContractCancellationType->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->hasPermissionTo('destroy_contract_cancellation_type')) {
            return response()->json(['status'=> 'Sem permissão para realizar a ação, procure o administrador do sistema!']);
        }
        try {
            $ContractCancellationType = $this->ContractCancellationType->where('id', $id)->first();
            $ContractCancellationType->delete();
            return response()->json(['status'=> 'Tipo de cancelamento excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }
}
