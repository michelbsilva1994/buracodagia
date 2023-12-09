<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\PhysicalPersonRequest;
use App\Http\Requests\People\PhysicalPersonUpdateRequest;
use App\Models\Contract\Contract;
use App\Models\People\PhysicalPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (!Auth::user()->hasPermissionTo('view_physical_person')) {
            return redirect()->route('services.peopleService')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $physicalPeople = $this->physicalPerson->paginate(10);
        return view('people.physicalPerson.index', compact('physicalPeople'));
    }

    public function filter(Request $request){
        if (!Auth::user()->hasPermissionTo('view_physical_person')) {
            return redirect()->route('services.peopleService')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $name = $request->name;

        $cpf = str_replace('.','', $request->cpf);
        $cpf = str_replace('-','', $cpf);

        if($name && $cpf){
            $physicalPeople = $this->physicalPerson->where('name','like',"%$name%")->where('cpf','like',"%$cpf%")->paginate(10);
            return view('people.physicalPerson.index', compact('physicalPeople'));
        }elseif($name){
            $physicalPeople = $this->physicalPerson->where('name','like',"%$name%")->paginate(10);
            return view('people.physicalPerson.index', compact('physicalPeople'));
        }elseif($cpf){
            $physicalPeople = $this->physicalPerson->where('cpf','like',"%$cpf%")->paginate(10);
            return view('people.physicalPerson.index', compact('physicalPeople'));
        }else{
            return redirect()->route('physicalPerson.index');
            $physicalPeople = $this->physicalPerson->paginate(10);
            return view('people.physicalPerson.index', compact('physicalPeople'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_physical_person')) {
            return redirect()->route('physicalPerson.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
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
        if (!Auth::user()->hasPermissionTo('store_physical_person')) {
            return redirect()->route('physicalPerson.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $cpf = str_replace('.','', $request->cpf);
            $cpf = str_replace('-','', $cpf);
            $cep = str_replace('-','', $request->cep);

            $physicalPerson = $this->physicalPerson;

            $physicalPerson->create([
                'name' => $request->name,
                'birth_date' => $request->birth_date,
                'email' => $request->email,
                'cpf' => $cpf,
                'rg' => $request->rg,
                'telephone' => $request->telephone,
                'cep' => $cep,
                'public_place' => $request->public_place,
                'nr_public_place' => $request->nr_public_place,
                'city' => $request->city,
                'state' => $request->state,
                'create_user' => Auth::user()->name,
                'update_user' => null
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
        if (!Auth::user()->hasPermissionTo('edit_physical_person')) {
            return redirect()->route('physicalPerson.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
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
        if (!Auth::user()->hasPermissionTo('update_physical_person')) {
            return redirect()->route('physicalPerson.edit', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

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
            $physicalPerson->update_user = Auth::user()->name;

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
        if (!Auth::user()->hasPermissionTo('destroy_physical_person')) {
            return response()->json(['status'=> 'Sem permissão para realizar a ação, procure o administrador do sistema!']);
        }

        try {
            $physicalPerson = $this->physicalPerson->findorfail($id);
            $physicalPerson->delete();
            return response()->json(['status' => 'Cadastro deletado com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }

    public function contractPerson($id_person){

        if (!Auth::user()->hasPermissionTo('view_contract_physical_person')) {
            return redirect()->route('physicalPerson.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $contracts = $this->contract->where('id_physical_person', '=' , $id_person)->get();
            $physicalPerson = $this->physicalPerson->where('id', '=' , $id_person)->first();

            return view('contract.contractPerson', compact(['contracts', 'physicalPerson']));
        } catch (\Throwable $th) {
            return redirect()->route('physicalPerson.index',$physicalPerson->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }
}
