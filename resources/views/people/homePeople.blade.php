@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Tipos de Pessoa</h1>
        </div>
        <div class="d-grid gap-2 col-sm-12 col-md-8 my-4 mx-auto">
            <a class="btn btn-lg btn-success" type="button" href="{{route('physicalPerson.index')}}">Pessoa Física</a>
            <a class="btn btn-lg btn-success" type="button" href="{{route('legalPerson.index')}}">Pessoa Jurídica</a>
          </div>
    </div>
@endsection
