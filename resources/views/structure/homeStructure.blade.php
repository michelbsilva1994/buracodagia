@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Estrutura</h1>
        </div>
        <div class="d-grid gap-2 col-sm-12 col-md-8 mx-auto">
            <a class="btn btn-success btn-lg" type="button" href="{{route('pavement.index')}}">Pavimento</a>
            <a class="btn btn-success btn-lg" type="button" href="{{route('store.index')}}">Lojas</a>
            <a class="btn btn-success btn-lg" type="button" href="{{route('equipment.index')}}">Equipamentos</a>
          </div>
    </div>
@endsection
