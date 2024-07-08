<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Contract\Contract;
use App\Models\People\PhysicalPerson;
use App\Models\Service\ServiceOrder;
use App\Models\Service\ServiceOrderHistory;
use App\Models\Structure\Equipment;
use App\Models\Structure\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceOrderController extends Controller
{
    public function __construct(ServiceOrder $serviceOrder,ServiceOrderHistory $serviceOrderHistory,PhysicalPerson $physicalPerson, Equipment $equipment, Contract $contract, Store $store)
    {
        $this->serviceOrder = $serviceOrder;
        $this->serviceOrderHistory = $serviceOrderHistory;
        $this->physicalPerson = $physicalPerson;
        $this->equipment = $equipment;
        $this->contract = $contract;
        $this->store = $store;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('view_service_order')) {
            return redirect()->route('dashboard')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $query = DB::table('service_orders');

        if(empty(Auth::user()->user_type_service_order) or Auth::user()->user_type_service_order == 'U'){
            $query->where('id_physical_person', '=' , Auth::user()->id_physical_people);
        }
        if(Auth::user()->user_type_service_order == 'E'){
            $query;
        }
        if($request->dt_opening_initial && $request->dt_opening_final){
            $query->where('dt_opening', '>=' ,$request->dt_opening_initial)->where('dt_opening', '<=' ,$request->dt_opening_final);
        }

        $serviceOrders = $query->paginate(10)->appends($request->input());

        if($request->ajax()){
            $view = view('service.service_order.paginate.service_order_data', compact('serviceOrders'))->render();
            $pagination = view('service.service_order.paginate.paginate', compact('serviceOrders'))->render();
            return response()->json(['html' => $view, 'pagination' => $pagination]);
        }

        return view('service.service_order.index', compact('serviceOrders'));
    }

    public function serviceOrderindex(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('view_service_order')) {
            return redirect()->route('dashboard')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $query = DB::table('service_orders');

        if(empty(Auth::user()->user_type_service_order) or Auth::user()->user_type_service_order == 'U'){
            $query->where('id_physical_person', '=' , Auth::user()->id_physical_people);
        }
        if(Auth::user()->user_type_service_order == 'E'){
            $query;
        }
        if($request->dt_opening_initial && $request->dt_opening_final){
            $query->where('dt_opening', '>=' ,$request->dt_opening_initial)->where('dt_opening', '<=' ,$request->dt_opening_final);
        }

        $serviceOrders = $query->paginate(10)->appends($request->input());

        if($request->ajax()){
            $view = view('service.service_order.paginate.service_order_data', compact('serviceOrders'))->render();
            $pagination = view('service.service_order.paginate.paginate', compact('serviceOrders'))->render();
            return response()->json(['html' => $view, 'pagination' => $pagination]);
        }

        return view('service.service_order.index', compact('serviceOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_service_order')) {
            return redirect()->route('serviceOrders.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $query = DB::table('contracts')
                                ->selectRaw('stores.id id_store,
                                                stores.name store,
                                                pavements.id id_pavement,
                                                pavements.name pavement')
                                ->join('contract_stores', 'contracts.id', '=', 'contract_stores.id_contract')
                                ->join('stores', 'contract_stores.id_store', '=', 'stores.id')
                                ->join('pavements', 'stores.id_pavement', '=', 'pavements.id');

            $requester = $this->physicalPerson->where('id', Auth::user()->id_physical_people)->first();

            if(is_null($requester)){
                return redirect()->route('serviceOrders.index')->with('alert', 'Seu usuário não tem pessoa física vínculada, entre em contato com a administração do sistema!');
            }else{
                if(empty(Auth::user()->user_type_service_order) or Auth::user()->user_type_service_order == 'U'){
                    $equipments = $this->equipment->where('status', 'A')->get();
                    $locations = $query->where('contracts.id_physical_person', '=', $requester->id)->get();
                }
                if(Auth::user()->user_type_service_order == 'E'){
                    $equipments = $this->equipment->where('status', 'A')->get();
                    $locations = $query->get();
                }

                return view('service.service_order.create', compact(['requester', 'equipments', 'locations']));
            }
        } catch (\Throwable $th) {
            return redirect()->route('serviceOrders.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('store_service_order')) {
            return redirect()->route('serviceOrders.create')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
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
        $serviceOrder = $this->serviceOrder->where('id', $id)->first();
        $user_requester = $this->physicalPerson->where('id', $serviceOrder->id_physical_person)->first();
        $user_executor = $this->physicalPerson->where('id', $serviceOrder->id_physcal_person_executor)->first();
        $serviceOrderHistory = $this->serviceOrderHistory->where('id_service_order', $serviceOrder->id)->get();

        return view('service.service_order.show', compact(['serviceOrder', 'user_requester', 'user_executor', 'serviceOrderHistory']));
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

    public function startWorkOrder(Request $request){
        if (!Auth::user()->hasPermissionTo('start_work_service_order')) {
            return redirect()->route('serviceOrders.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

            try {
                $serviceOrder = $this->serviceOrder->where('id', $request->id_service_order)->first();

                $serviceOrder->dt_process = Date('Y/m/d');
                $serviceOrder->id_status = 'P';
                $serviceOrder->id_physcal_person_executor = Auth::user()->id;
                $serviceOrder->update_user = Auth::user()->name;
                $serviceOrder->save();

                return response()->json(['status' => 'Ordem de serviço '.$serviceOrder->id.' iniciada com sucesso!']);

            } catch (\Throwable $th) {
                return response()->json(['error' => $th]);
            }
    }

    public function closeWorkOrder(Request $request){

        if (!Auth::user()->hasPermissionTo('close_work_service_order')) {
            return redirect()->route('serviceOrders.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $serviceOrder = $this->serviceOrder->where('id', $request->id_service_order)->first();

            $serviceOrder->dt_service = Date('Y/m/d');
            $serviceOrder->id_status = 'F';
            $serviceOrder->update_user = Auth::user()->name;
            $serviceOrder->save();

            return response()->json(['status' => 'Ordem de serviço '.$serviceOrder->id.' encerrada com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $serviceOrder]);
        }
    }

    public function storeHistory(Request $request, $serviceOrder){

        $serviceOrder = $this->serviceOrder->where('id', $serviceOrder)->first();

        $serviceOrderHistory = $this->serviceOrderHistory;

        $serviceOrderHistory->id_type_history = null;
        $serviceOrderHistory->ds_type_history = null;
        $serviceOrderHistory->history = $request->description;
        $serviceOrderHistory->dt_creation = Date('Y/m/d');
        $serviceOrderHistory->dt_release = Date('Y/m/d');
        $serviceOrderHistory->id_physical_person = Auth::user()->id_physical_people;
        $serviceOrderHistory->create_user = Auth::user()->name;
        $serviceOrderHistory->update_user = null;
        $serviceOrderHistory->id_service_order = $serviceOrder->id;

        $serviceOrderHistory->save();

        return redirect()->route('serviceOrders.show', $serviceOrder->id)->with('status', 'Histórico cadastrado com sucesso!');

    }
}
