@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="text-secondary mt-2">Usuários</h1>
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
        <div>
            <a href="{{route('user.index')}}" class="btn btn-success my-2"> Voltar</a>
        </div>
        <div>
            <h2 class="mt-4">Perfis de <b>{{ $user->name }}</b> </h2>
                        <form action="{{ route('user.rolesSync', ['user'=>$user->id]) }}" method="post" class="mt-4" autocomplete="off">
                            @csrf
                            @method('PUT')

                           @foreach($roles as $role)
                                <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="{{$role->id}}" name="{{$role->id}}" {{$role->can=='1'?'checked':''}}>
                                    <label class="custom-control-label" for="{{$role->id}}">
                                        {{$role->name}}
                                    </label>
                                </div>
                           @endforeach
                            <button type="submit" class="btn btn-block btn-success mt-4">Sincronizar Perfis do Usuário</button>
                        </form>
        </div>
    </div>
@endsection
