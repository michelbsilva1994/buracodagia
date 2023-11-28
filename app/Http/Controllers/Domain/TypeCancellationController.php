<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\TypeCancellation\TypeCancellationRequest;
use App\Http\Requests\Domain\TypeCancellation\TypeCancellationUpdateRequest;
use App\Models\Domain\TypeCancellation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeCancellationController extends Controller
{
    public function __construct(TypeCancellation $typeCancellation)
    {
        $this->typeCancellation = $typeCancellation;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('view_type_cancellation')) {
            return redirect()->route('services.domainService')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        $typeCancellation = $this->typeCancellation->all();
        return view('domain.type_cancellation.index', compact('typeCancellation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_type_cancellation')) {
            return redirect()->route('typeCancellation.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            return view('domain.type_cancellation.create');
        } catch (\Throwable $th) {
            return redirect()->route('typeCancellation.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeCancellationRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('store_type_cancellation')) {
            return redirect()->route('typeCancellation.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $this->typeCancellation->create([
                'value' => $request->value,
                'description' => $request->description,
                'status' => $request->status,
                'create_user' => Auth::user()->name,
                'update_user' => null
            ]);
            return redirect()->route('typeCancellation.index')->with('status','Tipo de cancelamento cadastrado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('typeCancellation.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
        if (!Auth::user()->hasPermissionTo('edit_type_cancellation')) {
            return redirect()->route('typeCancellation.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $typeCancellation = $this->typeCancellation->where('id', $id)->first();
            return view('domain.type_cancellation.edit', compact('typeCancellation'));
        } catch (\Throwable $th) {
            return redirect()->route('storeType.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TypeCancellationUpdateRequest $request, string $id)
    {
        if (!Auth::user()->hasPermissionTo('update_type_cancellation')) {
            return redirect()->route('typeCancellation.edit', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $typeCancellation = $this->typeCancellation->where('id', $id)->first();

            $typeCancellation->value = $request->value;
            $typeCancellation->description = $request->description;
            $typeCancellation->status = $request->status;
            $typeCancellation->update_user = Auth::user()->name;

            $typeCancellation->save();

            return redirect()->route('typeCancellation.index')->with('status','Tipo de cancelamento alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('typeCancellation.edit', $typeCancellation->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->hasPermissionTo('destroy_type_cancellation')) {
            return response()->json(['status'=> 'Sem permissão para realizar a ação, procure o administrador do sistema!']);
        }
        try {
            $typeCancellation = $this->typeCancellation->where('id', $id)->first();
            $typeCancellation->delete();
            return response()->json(['status'=> 'Tipo de cancelamento excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }
}
