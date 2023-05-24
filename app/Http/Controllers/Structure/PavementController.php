<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Structure\Pavement;

class PavementController extends Controller
{
    public function __construct(Pavement $pavement)
    {
        $this->pavement = $pavement;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pavementies = $this->pavement->all();
        return view('structure.pavement.index', compact('pavementies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('structure.pavement.create');
        } catch (\Throwable $th) {
            return redirect()->route('structure.pavement.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->pavement->create($request->all());
        return redirect()->route('pavement.index')->with('status', 'Pavimento cadastrado com sucesso!');
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
        //
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
