@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="text-secondary mt-2">Estrutura</h1>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto mt-5">
            <a class="btn btn-primary" type="button" href="{{route('pavement.index')}}">Pavimento</a>
            <a class="btn btn-primary" type="button" href="{{route('store.index')}}">Lojas</a>
          </div>
    </div>
@endsection
