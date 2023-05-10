<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\RoleRequest;
use App\Http\Requests\Security\RoleUpdateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('security.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        try {
            $role = Role::where('id', $id)->first();
            $role->update($request->all());
            return redirect()->route('role.index')->with('status', 'Perfil alterado com sucesso!');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
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
