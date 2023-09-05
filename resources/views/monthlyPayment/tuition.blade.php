@extends('layout.app')
@section('content')
    <div class="container mt-4">
        <div class="d-flex ">
            <h3>Mensalidades</h3>
        </div>
        <div class="mt-4">
            <form action="{{route('monthly.filter')}}" class="row" method="post">
                @csrf
                <div class="col-md-5">
                    <label for="contractor">Contrante</label>
                    <input type="text" name="contractor" id="contractor" class="form-control">
                </div>
                <div class="col-md-5">
                    <label for="due_date">Data Vencimento</label>
                    <input type="date" name="due_date" id="due_date" class="form-control">
                </div>
                <div class="col-2 mt-4">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tuition as $monthlyPayment)
                    <tr>
                        <td>{{$monthlyPayment->id}}</td>
                        <td>{{$monthlyPayment->name_contractor}}</td>
                        <td>{{date('d/m/Y', strtotime($monthlyPayment->due_date))}}</td>
                        <td>R$ {{$monthlyPayment->total_payable}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
