@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="text-secondary mt-2">Contratos</h1>
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
        <div>
            <a href="{{route('contract.create')}}" class="btn btn-success my-2"> + Novo Contrato</a>
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
                                <a class="mr-3 btn btn-sm btn-outline-success" href="{{route('contract.edit', ['contract' => $contract->id])}}">Editar</a>
                                <a class="mr-3 btn btn-sm btn-outline-secondary" href="{{route('contract.show', ['contract' => $contract->id])}}">Detalhe</a>
                                <a class="mr-3 btn btn-sm btn-outline-info" href="">Renovar</a>
                                <form action="{{route('contract.destroy', ['contract' => $contract->id])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input class="mr-3 btn btn-sm btn-outline-danger" type="submit" value="Remover">
                                </form>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
