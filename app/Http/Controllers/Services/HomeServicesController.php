<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeServicesController extends Controller
{
    public function securityService(){
        if (!Auth::user()->hasPermissionTo('view_security_management')) {
            return redirect()->route('dashboard')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        return view('security.homeSecurity');
    }

    public function domainService(){
        return view('domain.homeDomain');
    }

    public function peopleService(){
        return view('people.homePeople');
    }

    public function structureService(){
        return view('structure.homeStructure');
    }

    public function generationTuitions(){
       return view('monthlyPayment.homeMonthlyPayment');
    }
}
