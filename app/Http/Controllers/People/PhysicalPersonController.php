<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\PhysicalPersonRequest;
use App\Models\People\PhysicalPerson;
use Illuminate\Http\Request;

class PhysicalPersonController extends Controller
{
    public function __construct(PhysicalPerson $physicalPerson)
    {
        $this->physicalPerson = $physicalPerson;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $physicalPeople = $this->physicalPerson->all();
        return view('people.physicalPerson.index', compact('physicalPeople'));
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
        try {
            $this->physicalPerson->create($request->all());
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
