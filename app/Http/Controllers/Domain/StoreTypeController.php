<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\StoreType\StoreTypeRequest;
use App\Http\Requests\Domain\StoreType\StoreTypeUpdateRequest;
use App\Models\Domain\StoreType;
use Illuminate\Http\Request;

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
        $storeType = $this->storeType->all();
        return view('domain.store_type.index', compact('storeType'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        try {
            $this->storeType->create($request->all());
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
        try {
            $storeType = $this->storeType->where('id', $id)->first();
            $storeType->update($request->all());
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
        try {
            $storeType = $this->storeType->where('id', $id)->first();
            $storeType->delete();
            return redirect()->route('storeType.index')->with('status','Tipo de loja excluído com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('storeType.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }
}
