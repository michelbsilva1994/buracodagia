<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\LegalPersonRequest;
use App\Http\Requests\People\LegalPersonUpdateRequest;
use App\Models\People\LegalPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $cnpj = str_replace('.','',$request->cnpj);
            $cnpj = str_replace('/','',$cnpj);
            $cnpj = str_replace('-','',$cnpj);
            $cep = str_replace('-','', $request->cep);

            $legalPerson = $this->legalPerson;

            $legalPerson->create([
                'corporate_name' => $request->corporate_name,
                'fantasy_name' => $request->fantasy_name,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'cnpj' => $cnpj,
                'cep' => $cep,
                'public_place' => $request->public_place,
                'nr_public_place' => $request->nr_public_place,
                'city' => $request->city,
                'state' => $request->state,
                'create_user' => Auth::user()->name,
                'update_user' => null
            ]);

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
            $cnpj = str_replace('.','',$request->cnpj);
            $cnpj = str_replace('/','',$cnpj);
            $cnpj = str_replace('-','',$cnpj);
            $cep = str_replace('-','', $request->cep);

            $legalPerson = $this->legalPerson->findorfail($id);

            $legalPerson->corporate_name = $request->corporate_name;
            $legalPerson->fantasy_name = $request->fantasy_name;
            $legalPerson->email = $request->email;
            $legalPerson->telephone = $request->telephone;
            $legalPerson->cnpj = $cnpj;
            $legalPerson->cep = $cep;
            $legalPerson->public_place = $request->public_place;
            $legalPerson->nr_public_place = $request->nr_public_place;
            $legalPerson->city = $request->city;
            $legalPerson->state = $request->state;
            $legalPerson->update_user = Auth::user()->name;

            $legalPerson->save();

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
            return response()->json(['status' => 'Cadastro excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }
}
