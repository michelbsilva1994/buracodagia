<?php

namespace App\Http\Controllers\Reports;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelReport;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{

    public function reportUsersIndex(){
        return view('reports.index');
    }

    public function repostUsers(Request $request){
        $name = $request->name;

        $query = DB::table('users')
                    ->selectRaw('id,name, email');

        if($name){
            $query->where('name', 'like',"%$name%");
        }

        $users = $query->get();

        return $users->downloadExcel('users.xlsx', ExcelReport::XLSX ,true);
    }
}
