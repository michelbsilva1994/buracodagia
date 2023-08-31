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
                    @foreach ($monthlyPayment as $monthly)
                    <tr>
                        <td>{{$monthly->id}}</td>
                        <td>{{date('d/m/Y', strtotime($monthly->due_date))}}</td>
                        <td>R$ {{$monthly->total_payable}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
