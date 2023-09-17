<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeServicesController extends Controller
{
    public function securityService(){
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
}