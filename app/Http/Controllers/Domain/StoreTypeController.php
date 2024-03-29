<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\StoreType\StoreTypeRequest;
use App\Http\Requests\Domain\StoreType\StoreTypeUpdateRequest;
use App\Models\Domain\StoreType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreTypeController extends Controller
{
    public function __construct(StoreType $storeType)
    {
        $this->storeType = $storeType;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('view_store_type')) {
            return redirect()->route('services.domainService')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        $storeType = $this->storeType->all();
        return view('domain.store_type.index', compact('storeType'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_store_type')) {
            return redirect()->route('storeType.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            return view('domain.store_type.create');
        } catch (\Throwable $th) {
            return redirect()->route('storeType.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('store_store_type')) {
            return redirect()->route('storeType.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $this->storeType->create([
                'value' => $request->value,
                'description' => $request->description,
                'status' => $request->status,
                'create_user' => Auth::user()->name,
                'update_user' => null
            ]);
            return redirect()->route('storeType.index')->with('status','Tipo de loja cadastrado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('storeType.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
        if (!Auth::user()->hasPermissionTo('edit_store_type')) {
            return redirect()->route('storeType.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $storeType = $this->storeType->where('id', $id)->first();
            return view('domain.store_type.edit', compact('storeType'));
        } catch (\Throwable $th) {
            return redirect()->route('storeType.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTypeUpdateRequest $request, string $id)
    {
        if (!Auth::user()->hasPermissionTo('update_store_type')) {
            return redirect()->route('storeType.edit', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $storeType = $this->storeType->where('id', $id)->first();

            $storeType->value = $request->value;
            $storeType->description = $request->description;
            $storeType->status = $request->status;
            $storeType->update_user = Auth::user()->name;

            $storeType->save();

            return redirect()->route('storeType.index')->with('status','Tipo de loja alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('storeType.edit', $storeType->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->hasPermissionTo('destroy_store_type')) {
            return response()->json(['status'=> 'Sem permissão para realizar a ação, procure o administrador do sistema!']);
        }
        try {
            $storeType = $this->storeType->where('id', $id)->first();
            $storeType->delete();
            return response()->json(['status'=> 'Tipo da loja excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }
}
