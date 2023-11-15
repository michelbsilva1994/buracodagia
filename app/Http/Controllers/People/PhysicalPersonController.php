<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\PhysicalPersonRequest;
use App\Http\Requests\People\PhysicalPersonUpdateRequest;
use App\Models\Contract\Contract;
use App\Models\People\PhysicalPerson;
use Illuminate\Http\Request;

class PhysicalPersonController extends Controller
{
    public function __construct(PhysicalPerson $physicalPerson, Contract $contract)
    {
        $this->physicalPerson = $physicalPerson;
        $this->contract = $contract;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $physicalPeople = $this->physicalPerson->all();
        return view('people.physicalPerson.index', compact('physicalPeople'));
    }

    public function filter(Request $request){
        $name = $request->name;
        $cpf = $request->cpf;

        if($name && $cpf){
            $physicalPeople = $this->physicalPerson->where('name','like',"%$name%")->where('cpf','like',"%$cpf%")->get();
            return view('people.physicalPerson.index', compact('physicalPeople'));
        }elseif($name){
            $physicalPeople = $this->physicalPerson->where('name','like',"%$name%")->get();
            return view('people.physicalPerson.index', compact('physicalPeople'));
        }elseif($cpf){
            $physicalPeople = $this->physicalPerson->where('cpf','like',"%$cpf%")->get();
            return view('people.physicalPerson.index', compact('physicalPeople'));
        }else{
            $physicalPeople = $this->physicalPerson->all();
            return view('people.physicalPerson.index', compact('physicalPeople'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('people.physicalPerson.create');
        } catch (\Throwable $th) {
            return redirect()->route('physicalPerson.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(PhysicalPersonRequest $request)
    {
        $cpf = str_replace('.','', $request->cpf);
        $cpf = str_replace('-','', $cpf);
        $cep = str_replace('-','', $request->cep);

        try {
            $physicalPerson = $this->physicalPerson;

            $physicalPerson->name = $request->name;
            $physicalPerson->birth_date = $request->birth_date;
            $physicalPerson->email = $request->email;
            $physicalPerson->cpf = $cpf;
            $physicalPerson->rg = $request->rg;
            $physicalPerson->telephone = $request->telephone;
            $physicalPerson->cep = $cep;
            $physicalPerson->public_place = $request->public_place;
            $physicalPerson->nr_public_place = $request->nr_public_place;
            $physicalPerson->city = $request->city;
            $physicalPerson->state = $request->state;

            $physicalPerson->create([
                'name' => $physicalPerson->name,
                'birth_date' => $physicalPerson->birth_date,
                'email' => $physicalPerson->email,
                'cpf' => $physicalPerson->cpf,
                'rg' => $physicalPerson->rg,
                'telephone' => $physicalPerson->telephone,
                'cep' => $physicalPerson->cep,
                'public_place' => $physicalPerson->public_place,
                'nr_public_place' => $physicalPerson->nr_public_place,
                'city' => $physicalPerson->city,
                'state' => $physicalPerson->state
            ]);

            return redirect()->route('physicalPerson.index')->with('status','Cadastro efetuado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('physicalPerson.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
            $physicalPerson = $this->physicalPerson->where('id',$id)->first();
            return view('people.physicalPerson.edit', compact('physicalPerson'));
        } catch (\Throwable $th) {
            return redirect()->route('physicalPerson.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PhysicalPersonUpdateRequest $request, string $id)
    {
        try {
            $cpf = str_replace('.','', $request->cpf);
            $cpf = str_replace('-','', $cpf);
            $cep = str_replace('-','', $request->cep);

            $physicalPerson = $this->physicalPerson->findorfail($id);

            $physicalPerson->name = $request->name;
            $physicalPerson->birth_date = $request->birth_date;
            $physicalPerson->email = $request->email;
            $physicalPerson->cpf = $cpf;
            $physicalPerson->rg = $request->rg;
            $physicalPerson->telephone = $request->telephone;
            $physicalPerson->cep = $cep;
            $physicalPerson->public_place = $request->public_place;
            $physicalPerson->nr_public_place = $request->nr_public_place;
            $physicalPerson->city = $request->city;
            $physicalPerson->state = $request->state;

            $physicalPerson->save();

            return redirect()->route('physicalPerson.index')->with('status','Cadastro alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('physicalPerson.edit',$physicalPerson->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $physicalPerson = $this->physicalPerson->findorfail($id);
            $physicalPerson->delete();
            return response()->json(['status' => 'Cadastro deletado com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }

    public function contractPerson($id_person){
        $contracts = $this->contract->where('id_physical_person', '=' , $id_person)->get();
        $physicalPerson = $this->physicalPerson->where('id', '=' , $id_person)->first();

        return view('contract.contractPerson', compact(['contracts', 'physicalPerson']));
    }
}
