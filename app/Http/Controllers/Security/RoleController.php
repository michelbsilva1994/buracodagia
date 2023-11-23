<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\RoleRequest;
use App\Http\Requests\Security\RoleUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('view_role')) {
            return redirect()->route('services.securityService')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        $roles = Role::all();
        return view('security.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_role')) {
            return redirect()->route('role.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            return view('security.roles.create');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('store_role')) {
            return redirect()->route('role.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $role = new Role();
            $role->name = $request->name;
            $role->save();
            return redirect()->route('role.index')->with('status', 'Perfil cadastrado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('role.create')->with('error', 'Ops, ocorreu um erro inesperado!' . $th);
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
        if (!Auth::user()->hasPermissionTo('edit_role')) {
            return redirect()->route('role.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $role = Role::where('id', $id)->first();
            return view('security.roles.edit', compact('role'));
        } catch (\Throwable $th) {
            return redirect()->route('role.edit', $id)->with('error', 'Ops, ocorreu um erro inesperado!' . $th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, string $id)
    {
        if (!Auth::user()->hasPermissionTo('update_role')) {
            return redirect()->route('role.edit',$id)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $role = Role::where('id', $id)->first();
            $role->update($request->all());
            return redirect()->route('role.index',$id)->with('status', 'Perfil alterado com sucesso!');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->hasPermissionTo('destroy_role')) {
            return redirect()->route('role.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return redirect()->route('role.index')->with('status', 'Perfil excluído com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('role.index')->with('error', 'Ops, ocorreu um erro inesperado!' . $th);
        }
    }

    public function permissions($role)
    {
        if (!Auth::user()->hasPermissionTo('add_permission_role')) {
            return redirect()->route('role.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        $role = Role::where('id', $role)->first();
        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            if ($role->haspermissionTo($permission->name)) {
                $permission->can = true;
            } else {
                $permission->can = false;
            }
        }

        return view('security.roles.permissions', compact('role', 'permissions'));
    }

    public function permissionsSync(Request $request, $role)
    {
        if (!Auth::user()->hasPermissionTo('sync_permission')) {
            return redirect()->route('role.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $permissionRequest = $request->except(['_token', '_method']);

            foreach ($permissionRequest as $key => $value) {
                $permissions[] = Permission::where('id', $key)->first();
            }
            $role = Role::where('id', $role)->first();
            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            } else {
                $role->syncPermissions(null);
            }
            return redirect()->route('role.permission', $role->id)->with('status','Perfil sincronizado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('role.permission', $role->id)->with('status','Ops, ocorreu um erro inesperado!' . $th);
        }
    }
}
