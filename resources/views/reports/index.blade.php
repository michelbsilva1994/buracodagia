@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Relatório Usuários</h3>
        <a href="{{route('reports.users')}}" class="btn btn-success">Gerar Relatórios Usuários</a>
    </div>
@endsection
