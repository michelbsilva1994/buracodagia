@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="text-secondary mt-2">Domínios</h1>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto mt-5">
            <a class="btn btn-primary" type="button" href="{{route('storeStatus.index')}}">Status da Loja</a>
            <a class="btn btn-primary" type="button" href="{{route('storeType.index')}}">Tipo de Loja</a>
            <a class="btn btn-primary" type="button" href="{{route('typeContract.index')}}">Tipo de Contrato</a>
            <a class="btn btn-primary" type="button" href="{{route('typePayment.index')}}">Tipo de Pagamento</a>
            <a class="btn btn-primary" type="button" href="{{route('typeCharge.index')}}">Tipo de Cobrança</a>
          </div>
    </div>
@endsection
