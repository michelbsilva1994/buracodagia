@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h3 class="my-4 text-secondary text-center">Perfis de <b>{{ $user->name }}</b></h3>
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
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
                        <form action="{{ route('user.rolesSync', ['user'=>$user->id]) }}" method="post" class="col-sm-12 col-md-10 col-lg-6" autocomplete="off">
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
                           <div class="d-grid gap-2 d-md-flex justify-content-md-center my-5">
                            <button type="submit" class="btn btn-lg btn-success">Sincronizar Perfis do Usuário</button>
                            <a href="{{route('user.index')}}" class="btn btn-lg btn-danger"> Voltar</a>
                            </div>
                        </form>
        </div>
    </div>
@endsection
