<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\StoreStatus\StoreStatusRequest;
use App\Http\Requests\Domain\StoreStatus\StoreStatusUpdateRequest;
use App\Models\Domain\StoreStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (!Auth::user()->hasPermissionTo('view_store_status')) {
            return redirect()->route('services.domainService')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        $storeStatus = $this->storeStatus->all();
        return view('domain.store_status.index', compact('storeStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_store_status')) {
            return redirect()->route('storeStatus.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
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
        if (!Auth::user()->hasPermissionTo('store_store_status')) {
            return redirect()->route('storeStatus.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $this->storeStatus->create([
                'value' => $request->value,
                'description' => $request->description,
                'status' => $request->status,
                'create_user' => Auth::user()->name,
                'update_user' => null
            ]);
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
        if (!Auth::user()->hasPermissionTo('edit_store_status')) {
            return redirect()->route('storeStatus.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
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
        if (!Auth::user()->hasPermissionTo('update_store_status')) {
            return redirect()->route('storeStatus.edit', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $status = $this->storeStatus->where('id',$id)->first();

            $status->value = $request->value;
            $status->description = $request->description;
            $status->status = $request->status;
            $status->update_user = Auth::user()->name;

            $status->save();

            return redirect()->route('storeStatus.index')->with('status','Status alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('storeStatus.edit',$status->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasPermissionTo('destroy_store_status')) {
            return response()->json(['status'=> 'Sem permissão para realizar a ação, procure o administrador do sistema!']);
        }
        try {
            $status = $this->storeStatus->where('id',$id)->first();
            $status->delete();
            return response()->json(['status'=> 'Tipo de status da loja excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }
}
