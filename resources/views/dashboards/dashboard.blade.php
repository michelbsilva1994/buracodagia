@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form class="col-12" autocomplete="off" id="form-filter">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_initial">Data Vencimento Inicial</label>
                        <input type="date" name="due_date_initial" id="due_date_initial" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_initial">Data Vencimento Inicial</label>
                        <input type="date" name="due_date_initial" id="due_date_initial" class="form-control">
                    </div>
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                        <button type="submit" class="btn btn-lg btn-success" id="filter">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-12">
                {!! $dashboard->container() !!}
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 text-secondary text-center">
                <div>
                    <h3 class="mt-5 col-md-12 col-sm-12">Valores Recebidos</h3>
                    <h5>PIX: R$ {{number_format($pix, 2, ',', '.')}}</h5>
                    <h5>Dinheiro: R$ {{number_format($money, 2, ',', '.')}}</h5>
                    <h5>Cartão de Débito: R$ {{number_format($debit_card, 2, ',', '.')}}</h5>
                    <h5>Cartão de Crédito: R$ {{number_format($credit_card, 2, ',', '.')}}</h5>
                </div>
                <div class="mt-5 col-md-12 col-sm-12">
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
