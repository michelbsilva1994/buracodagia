@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Geração de mensalidades</h1>
        </div>
        <div class="d-grid gap-2 col-sm-12 col-md-8 my-4 mx-auto">
            <a class="btn btn-lg btn-success" type="button" href="{{route('monthly.index')}}">Gerar Mensalidades</a>
            @can('generate_retroactive_monthly_payment')
                <a class="btn btn-lg btn-success" type="button" href="{{route('monthly.createGenerateRetroactiveMonthlyPayment')}}">Gerar Mensalidade Retroativa</a>
            @endcan
          </div>
    </div>
@endsection
