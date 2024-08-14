@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Dashboards</h1>
        </div>
        <div class="d-grid gap-2 col-sm-12 col-md-8 my-4 mx-auto">
            <a class="btn btn-lg btn-success" type="button" href="{{route('dashboardCharts.dashboardCharts')}}">Mensalidades por Data de Vencimento</a>
        </div>
        <div class="d-grid gap-2 col-sm-12 col-md-8 my-4 mx-auto">
            <a class="btn btn-lg btn-success" type="button" href="{{route('dashboardCharts.financialLowersDashboard')}}">Valores de Recebimento por Data de Baixa</a>
        </div>
    </div>
@endsection
