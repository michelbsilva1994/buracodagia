<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Security\UserRequest;
use App\Http\Requests\Security\UserUpdateRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('view_user')) {
            return redirect()->route('user.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        
        $users = $this->user->all();
        return view('security.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create_user')) {
            return redirect()->route('user.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            return view('security.users.create');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('store_user')) {
            return redirect()->route('user.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
            try {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                $user->save();
                return redirect()->route('user.index')->with('status','Usuário cadastrado com sucesso!');
            } catch (\Throwable $th) {
                return redirect()->route('user.create')->with('error','Ops, ocorreu um erro inesperado!'.$th);
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
        if (!Auth::user()->hasPermissionTo('edit_user')) {
            return redirect()->route('user.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $user = $this->user->where('id',$id)->first();
            return view('security.users.edit', compact('user'));
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('update_user')) {
            return redirect()->route('user.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        try {
            $user = $this->user->findorfail($id);
            $user->update($request->all());
            return redirect()->route('user.index')->with('status','Usuário alterado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('user.edit', $id)->with('error','Ops, ocorreu um erro inesperado!'.$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->hasPermissionTo('destroy_user')) {
            return redirect()->route('user.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }
        try {
            $user = $this->user->findorfail($id);
            $user->delete();
            return response()->json(['status' => 'Usuário excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Ops, ocorreu um erro inesperado!']);
        }
    }

    public function roles($user){

        if (!Auth::user()->hasPermissionTo('roles_user')) {
             return redirect()->route('user.index')->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
         }

        $user = $this->user->where('id', $user)->first();
        $roles = $this->role->all();

        foreach($roles as $role){
            if ($user->hasRole($role->name)) {
                $role->can = true;
            }else{
                $role->can = false;
            }
        }
        return view('security.users.role', compact('roles','user'));
    }

    public function rolesSync(Request $request, $user){

        if (!Auth::user()->hasPermissionTo('roles_sync_user')) {
            return redirect()->route('user.roles', $user)->with('alert', 'Sem permissão para realizar a ação, procure o administrador do sistema!');
        }

        $roleRequest = $request->except('_token', '_method');

        foreach ($roleRequest as $key => $value) {
            $roles[] = Role::where('id',$key)->first();
        }

        $user = $this->user->where('id', $user)->first();
            if (!empty($roles)) {
                $user->syncRoles($roles);
            }else{
                $user->syncRoles(null);
            }

        return redirect()->route('user.roles',['user' => $user->id])->with('status','Perfis sincronizados com sucesso!');
    }

}
