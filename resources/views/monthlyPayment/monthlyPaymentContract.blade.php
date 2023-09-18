@extends('layout.app')
@section('content')
    <div class="container">
        <div class="my-4 text-secondary text-center">
            <h3>Mensalidades</h3>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start my-3">
            <a href="{{route('physical.contractPerson', ['id_person' => $physicalPerson->id])}}" class="btn btn-lg btn-danger mr-2">Voltar</a>
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
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>Nº Mensalidade</td>
                        <td>Data de vencimento</td>
                        <td>Valor a pagar</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlyPayment as $monthly)
                    <tr>
                        <td>{{$monthly->id}}</td>
                        <td>{{date('d/m/Y', strtotime($monthly->due_date))}}</td>
                        <td>R$ {{$monthly->total_payable}}</td>
                        <td>
                            @if(empty($monthly->dt_payday) && empty($monthly->dt_cancellation))
                                <a class="mr-3 btn btn-sm btn-success" href="{{route('monthly.lowerMonthlyFeeContract', ['monthlyPayment' => $monthly->id])}}">Baixar</a>
                                <a class="mr-3 btn btn-sm btn-danger" href="{{route('monthly.cancelTuitionContract', ['monthlyPayment' => $monthly->id])}}">Cancelar</a>
                            @else
                                <h6>-</h6>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
