@extends('layout.app')
@section('content')
    <div class="container">
        <div class="mt-4">
            @foreach ($contracts as $contract)
                <h3 class="text-secondary">Tipo de Pessoa: {{$contract->type_person}}</h3>
                <h3 class="text-secondary">Tipo de Contrato: {{$contract->type_contract}}</h3>
                <h3 class="text-secondary">Contratante: {{$contract->name_contractor}}</h3>
                <h3 class="text-secondary">CPF/CNPJ: {{$contract->cpf ?? $contract->cnpj}}</h3>
                <h3 class="text-secondary">Data do Contrato: {{$contract->dt_contraction}}</h3>
            @endforeach
        </div>
        <hr>
    </div>
@endsection
