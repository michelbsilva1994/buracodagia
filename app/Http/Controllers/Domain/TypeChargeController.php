<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\typeCharge\TypeChargeRequest;
use App\Http\Requests\Domain\typeCharge\TypeChargeUpdateRequest;
use App\Models\Domain\TypeCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeChargeController extends Controller
{
    public function __construct(TypeCharge $typeCharge)
    {
        $this->typeCharge = $typeCharge;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('view_type_charge')) {
            return redirect()->route('services.domainService')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        $typeCharge = $this->typeCharge->all();
        return view('domain.type_charge.index', compact('typeCharge'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_type_charge')) {
            return redirect()->route('typeCharge.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            return view('domain.type_charge.create');
        } catch (\Throwable $th) {
            return redirect()->route('typeCharge.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeChargeRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('store_type_charge')) {
            return redirect()->route('typeCharge.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $this->typeCharge->create([
                'value' => $request->value,
                'description' => $request->description,
                'status' => $request->status,
                'create_user' => Auth::user()->name,
                'update_user' => null
            ]);
            return redirect()->route('typeCharge.index')->with('status','Tipo de cobrança cadastrado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('typeCharge.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
        if (!Auth::user()->hasPermissionTo('edit_type_charge')) {
            return redirect()->route('typeCharge.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $type = $this->typeCharge->where('id',$id)->first();
            return view('domain.type_charge.edit', compact('type'));
        } catch (\Throwable $th) {
            return redirect()->route('storeStatus.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TypeChargeUpdateRequest $request, string $id)
    {
        if (!Auth::user()->hasPermissionTo('update_type_charge')) {
            return redirect()->route('typeCharge.edit', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $type = $this->typeCharge->where('id',$id)->first();

            $type->value = $request->value;
            $type->description = $request->description;
            $type->status = $request->status;
            $type->update_user = Auth::user()->name;

            $type->save();

            return redirect()->route('typeCharge.index')->with('status','Tipo de cobrança alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('typeCharge.edit',$type->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->hasPermissionTo('destroy_type_charge')) {
            return response()->json(['status'=> 'Sem permissão para realizar a ação, procure o administrador do sistema!']);
        }
        try {
            $type = $this->typeCharge->where('id',$id)->first();
            $type->delete();
            return response()->json(['status'=> 'Tipo de cobrança excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }
}
