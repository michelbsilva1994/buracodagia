@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h3 class="my-4 text-secondary text-center">Mensalidades</h3>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('alert'))
            <div class="alert alert-warning" role="alert">
                {{ session('alert') }}
            </div>
        @endif
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form action="{{route('monthly.filter')}}" class="col-12 row" method="post">
                @csrf
                <div class="col-sm-12 col-md-6">
                    <label for="contractor">Contrante</label>
                    <input type="text" name="contractor" id="contractor" class="form-control">
                </div>
                <div class="col-sm-12 col-md-6">
                    <label for="due_date">Data Vencimento</label>
                    <input type="date" name="due_date" id="due_date" class="form-control">
                </div>
                <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-2">
                    <button type="submit" class="btn btn-block btn-success">Filtrar</button>
                </div>
            </form>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>Nº Mensalidade</td>
                        <td>Contrante</td>
                        <td>Data de vencimento</td>
                        <td>Valor a pagar</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tuition as $monthlyPayment)
                    <tr>
                        <td>{{$monthlyPayment->id}}</td>
                        <td>{{$monthlyPayment->name_contractor}}</td>
                        <td>{{date('d/m/Y', strtotime($monthlyPayment->due_date))}}</td>
                        <td>R$ {{$monthlyPayment->total_payable}}</td>
                        <td>
                            @if(empty($monthlyPayment->dt_payday) && empty($monthlyPayment->dt_cancellation))
                                <div class="d-flex">
                                    <a class="mr-3 btn btn-sm btn-success" href="{{route('monthly.lowerMonthlyFee', ['monthlyPayment' => $monthlyPayment->id])}}">Baixar</a>
                                    <a class="mr-3 btn btn-sm btn-danger" href="{{route('monthly.cancelTuition', ['monthlyPayment' => $monthlyPayment->id])}}">Cancelar</a>
                                </div>
                            @else
                                <div>
                                    <h6>-</h6>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
