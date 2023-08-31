@extends('layout.app')
@section('content')
    <div class="container mt-4">
        <div class="d-flex ">
            <h3>Mensalidades</h3>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>Nº Mensalidade</td>
                        <td>Data de vencimento</td>
                        <td>Valor a pagar</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tuition as $monthlyPayment)
                    <tr>
                        <td>{{$monthlyPayment->id}}</td>
                        <td>{{date('d/m/Y', strtotime($monthlyPayment->due_date))}}</td>
                        <td>{{$monthlyPayment->id_contract}}</td>
                        <td>R$ {{$monthlyPayment->total_payable}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
