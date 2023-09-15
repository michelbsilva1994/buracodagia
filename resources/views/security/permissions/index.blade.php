@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Permissão</h1>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="d-grid gap-2 d-md-flex justify-content-md-start my-4">
            <a href="{{route('permission.create')}}" class="btn btn-lg btn-success"> + Criar Permissão</a>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Permissão</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{$permission->id}}</td>
                            <td>{{$permission->name}}</td>
                            <td class="d-flex">
                                <a class="mr-3 btn btn-sm btn-outline-success" href="{{route('permission.edit',['permission'=>$permission->id])}}">Editar</a>
                                <form action="{{route('permission.destroy', ['permission' => $permission->id])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input class="btn btn-sm btn-outline-danger" type="submit" value="Remover">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
