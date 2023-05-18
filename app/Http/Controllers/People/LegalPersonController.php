<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\LegalPersonRequest;
use App\Http\Requests\People\LegalPersonUpdateRequest;
use App\Models\People\LegalPerson;
use Illuminate\Http\Request;

class LegalPersonController extends Controller
{
    public function __construct(LegalPerson $legalPerson)
    {
        $this->legalPerson = $legalPerson;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legalPerson = $this->legalPerson->all();
        return view('people.legalPerson.index', compact('legalPerson'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('people.legalPerson.create');
        } catch (\Throwable $th) {
            return redirect()->route('legalPerson.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LegalPersonRequest $request)
    {
        try {
            $this->legalPerson->create($request->all());
            return redirect()->route('legalPerson.index')->with('status','Cadastro realizado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('legalPerson.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
            $legalPerson = $this->legalPerson->where('id',$id)->first();
            return view('people.legalPerson.edit', compact('legalPerson'));
        } catch (\Throwable $th) {
            return redirect()->route('legalPerson.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LegalPersonUpdateRequest $request, string $id)
    {
        try {
            $legalPerson = $this->legalPerson->findorfail($id);
            $legalPerson->update($request->all());
            return redirect()->route('legalPerson.index')->with('status','Cadastro alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('legalPerson.edit',$legalPerson->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $legalPerson = $this->legalPerson->findorfail($id);
            $legalPerson->delete();
            return redirect()->route('legalPerson.index')->with('status','Cadastro excluído com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('legalPerson.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }
}
