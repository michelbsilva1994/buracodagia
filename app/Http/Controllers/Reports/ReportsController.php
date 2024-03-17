<?php

namespace App\Http\Controllers\Reports;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{

    public function reportUsersIndex(){
        return view('reports.index');
    }

    public function repostUsers(){
        $exports = new UsersExport();



        return Excel::download($exports, 'users.xlsx');
    }
}
