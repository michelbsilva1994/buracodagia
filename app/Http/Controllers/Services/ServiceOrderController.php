<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Contract\Contract;
use App\Models\People\PhysicalPerson;
use App\Models\Service\ServiceOrder;
use App\Models\Structure\Equipment;
use App\Models\Structure\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceOrderController extends Controller
{
    public function __construct(ServiceOrder $serviceOrder,PhysicalPerson $physicalPerson, Equipment $equipment, Contract $contract, Store $store)
    {
        $this->serviceOrder = $serviceOrder;
        $this->physicalPerson = $physicalPerson;
        $this->equipment = $equipment;
        $this->contract = $contract;
        $this->store = $store;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceOrders = $this->serviceOrder->all();
        return view('service.service_order.index', compact('serviceOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $requester = $this->physicalPerson->where('id', Auth::user()->id_physical_people)->first();
        $equipments = $this->equipment->where('status', 'A')->get();

        $locations = DB::table('contracts')
                            ->selectRaw('stores.id id_store,
                                         stores.name store,
                                         pavements.id id_pavement,
                                         pavements.name pavement')
                            ->join('contract_stores', 'contracts.id', '=', 'contract_stores.id_contract')
                            ->join('stores', 'contract_stores.id_store', '=', 'stores.id')
                            ->join('pavements', 'stores.id_pavement', '=', 'pavements.id')
                            ->where('contracts.id_physical_person', '=', $requester->id)
                            ->get();

        return view('service.service_order.create', compact(['requester', 'equipments', 'locations']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pavement_store = $this->store->where('id', $request->location)->first();
        $physical_person_requester = $this->physicalPerson->where('id', $request->id_requester)->first();

        try {
            $serviceOrder = $this->serviceOrder->create([
                'id_physical_person' => $request->id_requester,
                'id_store' => $request->location,
                'id_pavement' => $pavement_store->id_pavement,
                'id_equipment' => $request->equipment,
                'title' => $request->title,
                'description' => $request->description,
                'contact' => $physical_person_requester->telephone,
                'dt_opening' => Date('Y/m/d'),
                'dt_process' => null,
                'dt_service' => null,
                'id_status' => 'A',
                'id_physcal_person_executor' => null,
                'create_user' => Auth::user()->name,
                'update_user' => null
            ]);

            return redirect()->route('serviceOrders.index')->with('status', 'Ordem de serviço '.$serviceOrder->id .' aberta com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('serviceOrders.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
