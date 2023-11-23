@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Segurança</h1>
        </div>
        @if (session('alert'))
            <div class="alert alert-warning" role="alert">
                {{ session('alert') }}
            </div>
        @endif
        <div class="d-grid gap-2 col-sm-12 col-md-8 my-4 mx-auto">
            <a class="btn btn-lg btn-success" type="button" href="{{route('role.index')}}">Perfis</a>
            <a class="btn btn-lg btn-success" type="button" href="{{route('permission.index')}}">Permissões</a>
          </div>
    </div>
@endsection
