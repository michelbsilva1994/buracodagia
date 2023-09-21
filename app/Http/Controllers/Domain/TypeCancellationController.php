<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\TypeCancellation\TypeCancellationRequest;
use App\Http\Requests\Domain\TypeCancellation\TypeCancellationUpdateRequest;
use App\Models\Domain\TypeCancellation;
use Illuminate\Http\Request;

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
        $typeCancellation = $this->typeCancellation->all();
        return view('domain.type_cancellation.index', compact('typeCancellation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        try {
            $this->typeCancellation->create($request->all());
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
        try {
            $typeCancellation = $this->typeCancellation->where('id', $id)->first();
            $typeCancellation->update($request->all());
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
        try {
            $typeCancellation = $this->typeCancellation->where('id', $id)->first();
            $typeCancellation->delete();
            return response()->json(['status'=> 'Tipo de cancelamento excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }
}
