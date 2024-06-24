@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                {!! $dashboard->container() !!}
            </div>
            <div class="col-6 text-secondary text-center">
                <div>
                    <h3 class="mt-5">Valores Recebidos</h3>
                    <h5>PIX: R$ {{number_format($pix, 2, ',', '.')}}</h5>
                    <h5>Dinheiro: R$ {{number_format($money, 2, ',', '.')}}</h5>
                    <h5>Cartão de Débito: R$ {{number_format($debit_card, 2, ',', '.')}}</h5>
                    <h5>Cartão de Crédito: R$ {{number_format($credit_card, 2, ',', '.')}}</h5>
                </div>
                <div class="mt-5">
                    <h3>Totais</h3>
                    <h5>Valor Total: R$ {{number_format($total_receivable, 2, ',', '.')}}</h5>
                    <h5>Total Recebido: R$ {{number_format($total_paid, 2, ',', '.')}}</h5>
                    <h5>Total à Receber: R$ {{number_format($total_received, 2, ',', '.')}}</h5>
                </div>
            </div>
            {!! $dashboard->script() !!}
        </div>
    </div>
@endsection
