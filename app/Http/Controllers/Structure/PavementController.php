<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Structure\Pavement\PavementeRequest;
use App\Http\Requests\Structure\Pavement\PavementeUpdateRequest;
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
        try {
            $this->pavement->create($request->all());
            return redirect()->route('pavement.index')->with('status', 'Pavimento cadastrado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('pavement.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
        $pavement = $this->pavement->where('id',$id)->first();
        return view('structure.pavement.edit', compact('pavement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PavementeUpdateRequest $request, string $id)
    {
        try {
            $pavement = $this->pavement->where('id',$id)->first();
            $pavement->update($request->all());
            return redirect()->route('pavement.index')->with('status', 'Pavimento alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('pavement.edit', $pavement->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pavement = $this->pavement->where('id',$id)->first();
            $pavement->delete();
            return redirect()->route('pavement.index')->with('status', 'Pavimento excluído com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('pavement.edit', $pavement->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }
}
