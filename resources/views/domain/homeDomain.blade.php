@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Domínios</h1>
        </div>
        <div class="d-grid gap-2 col-sm-12 col-md-8 my-4 mx-auto">
            <a class="btn btn-lg btn-success" type="button" href="{{route('storeStatus.index')}}">Status da Loja</a>
            <a class="btn btn-lg btn-success" type="button" href="{{route('storeType.index')}}">Tipo de Loja</a>
            <a class="btn btn-lg btn-success" type="button" href="{{route('typeContract.index')}}">Tipo de Contrato</a>
            <a class="btn btn-lg btn-success" type="button" href="{{route('typePayment.index')}}">Tipo de Pagamento</a>
            <a class="btn btn-lg btn-success" type="button" href="{{route('typeCharge.index')}}">Tipo de Cobrança</a>
          </div>
    </div>
@endsection
