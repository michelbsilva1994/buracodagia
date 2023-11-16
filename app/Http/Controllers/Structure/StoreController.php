<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Structure\Store\StoreRequest;
use App\Http\Requests\Structure\Store\StoreUpdateRequest;
use App\Models\Contract\ContractStore;
use App\Models\Domain\StoreStatus;
use App\Models\Domain\StoreType;
use App\Models\Structure\Pavement;
use App\Models\Structure\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __construct(Store $store, Pavement $pavement, StoreType $storeType, StoreStatus $storeStatus, ContractStore $contractStore)
    {
        $this->store = $store;
        $this->pavement = $pavement;
        $this->storeType = $storeType;
        $this->storeStatus = $storeStatus;
        $this->contractStore = $contractStore;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = $this->store->all();
        return view('structure.store.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pavementies = $this->pavement->where('status', 'A')->get();
        $storeType =  $this->storeType->where('status', 'A')->get();
        $storeStatues = $this->storeStatus->where('status', 'A')->get();
        try {
            return view('structure.store.create', compact('pavementies', 'storeType','storeStatues'));
        } catch (\Throwable $th) {
            return redirect()->route('store.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->store->create([
                'name' => $request->name,
                'status' => $request->status,
                'type' => $request->type,
                'description' => $request->description,
                'id_pavement' => $request->id_pavement,
                'create_user' => Auth::user()->name,
                'update_user' => null
            ]);
            return redirect()->route('store.index')->with('status', 'Loja cadastrada com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('store.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
            $pavementies = $this->pavement->where('status', 'A')->get();
            $store = $this->store->where('id',$id)->first();
            $storeType =  $this->storeType->all();
            $storeStatues = $this->storeStatus->where('status', 'A')->get();

            $contractStore = $this->contractStore->where('id_store',$id)->count();
            $contract = $this->contractStore->select('id_contract')->where('id_store',$id)->first();

            if($contractStore > 0){
                return redirect()->route('store.index')->with('alert','Não pode alterar a '.$store->name.' - '.$store->pavement->name.' pois à mesma está vínculada ao contrato '.$contract->id_contract.' !');
            }else{
                return view('structure.store.edit', compact('store', 'pavementies','storeType','storeStatues'));
            }
        } catch (\Throwable $th) {
            return redirect()->route('store.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateRequest $request, string $id)
    {
        try {
            $store = $this->store->where('id',$id)->first();

            $store->name = $request->name;
            $store->status = $request->status;
            $store->type = $request->type;
            $store->description = $request->description;
            $store->id_pavement = $request->id_pavement;
            $store->update_user = Auth::user()->name;

            $store->save();

            return redirect()->route('store.index')->with('status', 'Loja alterada com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('store.update', $store->id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $store = $this->store->where('id',$id)->first();
            $contractStore = $this->contractStore->where('id_store',$id)->count();
            $contract = $this->contractStore->select('id_contract')->where('id_store',$id)->first();

            if($contractStore > 0 ){
                return response()->json(['linked' => 'A loja '.$store->name.' - '.$store->pavement->name.' não pode ser excluída pois está vínculada ao contrato '.$contract->id_contract.' !']);
            }else{
                $store->delete();
                return response()->json(['status' => 'Loja excluída com sucesso!'] );
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }
}
