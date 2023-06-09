<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\StoreStatus\StoreStatusRequest;
use App\Http\Requests\Domain\StoreStatus\StoreStatusUpdateRequest;
use App\Models\Domain\StoreStatus;
use Illuminate\Http\Request;

class StoreStatusController extends Controller
{
    public function __construct(StoreStatus $storeStatus)
    {
        $this->storeStatus = $storeStatus;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $storeStatus = $this->storeStatus->all();
        return view('domain.store_status.index', compact('storeStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('domain.store_status.create');
        } catch (\Throwable $th) {
            return redirect()->route('storeStatus.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request)
    {
        try {
            $this->storeStatus->create($request->all());
            return redirect()->route('storeStatus.index')->with('status','Status cadastrado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('storeStatus.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
            $status = $this->storeStatus->where('id',$id)->first();
            return view('domain.store_status.edit', compact('status'));
        } catch (\Throwable $th) {
            return redirect()->route('storeStatus.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreStatusUpdateRequest $request, string $id)
    {
        try {
            $status = $this->storeStatus->where('id',$id)->first();
            $status->update($request->all());
            return redirect()->route('storeStatus.index')->with('status','Status alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('storeStatus.create',$status->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $status = $this->storeStatus->where('id',$id)->first();
            $status->delete();
            return redirect()->route('storeStatus.index')->with('status','Status excluído com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('storeStatus.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }
}
