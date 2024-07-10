<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Structure\Equipment\EquipmentRequest;
use App\Http\Requests\Structure\Equipment\EquipmentUpdateRequest;
use App\Models\Structure\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function __construct(Equipment $equipment)
    {
        $this->equipment = $equipment;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipments = $this->equipment->all();

        return view('structure.equipment.index', compact('equipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('structure.equipment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipmentRequest $request)
    {
        try {
            $this->equipment->create([
                'name' => $request->name,
                'status' => $request->status,
                'create_user' => Auth::user()->name,
                'update_user' => null
            ]);
            return redirect()->route('equipment.index')->with('status', 'Equipamento cadastrado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('equipment.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
            $equipment = $this->equipment->where('id',$id)->first();
            return view('structure.equipment.edit', compact('equipment'));
        } catch (\Throwable $th) {
            return redirect()->route('equipment.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EquipmentUpdateRequest $request, string $id)
    {
        try {
            $equipment = $this->equipment->where('id',$id)->first();

            $equipment->name = $request->name;
            $equipment->status = $request->status;
            $equipment->update_user = Auth::user()->name;

            $equipment->save();

            return redirect()->route('equipment.edit', $equipment->id)->with('status','Equipamento alterado com sucesso!');

        } catch (\Throwable $th) {
            return redirect()->route('equipment.edit', $equipment->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $equipment = $this->equipment->where('id',$id)->first();
            $equipment->delete();
            return response()->json(['status' => 'Equipamento excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ops, ocorreu um erro inesperado!']);
        }
    }
}
