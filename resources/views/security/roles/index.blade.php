@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Perfis</h1>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start my-4">
            <a href="{{route('role.create')}}" class="btn btn-lg btn-success"> + Criar Perfil</a>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Perfil</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td class="d-flex">
                                <a class="mr-3 btn btn-sm btn-outline-success" href="{{route('role.edit', ['role'=>$role->id])}}">Editar</a>
                                <form action="{{route('role.destroy', ['role'=>$role->id])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input class="mr-3 btn btn-sm btn-outline-danger" type="submit" value="Remover">
                                </form>
                                <a href="{{route('role.permission', $role->id)}}" class="btn btn-sm btn-outline-info">Permissões</a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
