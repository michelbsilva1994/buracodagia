<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\PermissionRequest;
use App\Http\Requests\Security\PermissionUpdateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('view_permission')) {
            return redirect()->route('services.securityService')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $permissions = Permission::all();
        return view('security.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_permission')) {
            return redirect()->route('permission.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            return view('security.permissions.create');
        } catch (\Throwable $th) {
            return redirect()->route('permission.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('store_permission')) {
            return redirect()->route('permission.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permission.index')->with('status', 'Permissão cadastrada com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('permission.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
        if (!Auth::user()->hasPermissionTo('edit_permission')) {
            return redirect()->route('permission.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $permission = Permission::where('id', $id)->first();
            return view('security.permissions.edit', compact('permission'));
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionUpdateRequest $request, string $id)
    {
        if (!Auth::user()->hasPermissionTo('store_permission')) {
            return redirect()->route('permission.create', $id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $permission = Permission::findOrFail($id);
            $permission->update($request->all());
            return redirect()->route('permission.index')->with('status', 'Permissão alterada com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('permission.edit',$id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->hasPermissionTo('destroy_permission')) {
            return redirect()->route('permission.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            return redirect()->route('permission.index')->with('status', 'Permissão excluída com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('permission.index')->with('error', 'Ops, ocorreu um erro inesperado!'.$th);
        }
    }
}
