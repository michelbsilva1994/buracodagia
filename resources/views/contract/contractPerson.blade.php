@extends('layout.app')
@section('content')
    <div class="container mt-4">
        <div class="d-flex ">
            <h3>Contratos:</h3><h3 class="ml-3">{{$physicalPerson->name}}</h3>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Tipo de Pessoa</td>
                        <td>Tipo de Contrato</td>
                        <td>Contrante</td>
                        <td>CPF/CNPJ</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contracts as $contract)
                    <tr>
                            <td>{{$contract->id}}</td>
                            <td>{{$contract->type_person}}</td>
                            <td>{{$contract->type_contract}}</td>
                            <td>{{$contract->name_contractor}}</td>
                            <td>{{$contract->cpf ?? $contract->cnpj}}</td>
                            <td class="d-flex">
                                <a class="mr-3 btn btn-sm btn-outline-success" href="{{route('monthly.MonthlyPaymentContract', ['contract' => $contract->id])}}">Mensalidades</a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
