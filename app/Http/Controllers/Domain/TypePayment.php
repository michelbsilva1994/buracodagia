<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\TypePayment\TypePaymentRequest;
use App\Http\Requests\Domain\TypePayment\TypePaymentUpdateRequest;
use App\Models\Domain\TypePayment as DomainTypePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypePayment extends Controller
{
    public function __construct(DomainTypePayment $typePayment)
    {
        $this->typePayment = $typePayment;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typePayment = $this->typePayment->all();
        return view('domain.type_payment.index', compact('typePayment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('domain.type_payment.create');
        } catch (\Throwable $th) {
            return redirect()->route('typePayment.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypePaymentRequest $request)
    {
        try {
            $this->typePayment->create([
                'value' => $request->value,
                'description' => $request->description,
                'status' => $request->status,
                'create_user' => Auth::user()->name,
                'update_user' => null
            ]);
            return redirect()->route('typePayment.index')->with('status','Tipo de pagamento cadastrado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('typePayment.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
            $typePayment = $this->typePayment->where('id', $id)->first();
            return view('domain.type_payment.edit', compact('typePayment'));
        } catch (\Throwable $th) {
            return redirect()->route('typePayment.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TypePaymentUpdateRequest $request, string $id)
    {
        try {
            $typePayment = $this->typePayment->where('id', $id)->first();

            $typePayment->value = $request->value;
            $typePayment->description = $request->description;
            $typePayment->status = $request->status;
            $typePayment->update_user = Auth::user()->name;

            $typePayment->save();

            return redirect()->route('typePayment.index')->with('status','Tipo de pagamento alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('typePayment.edit', $typePayment->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $typePayment = $this->typePayment->where('id', $id)->first();
            $typePayment->delete();
            return response()->json(['status'=> 'Tipo de pagamento excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ops, ocorreu um erro inesperado!']);
        }
    }
}
