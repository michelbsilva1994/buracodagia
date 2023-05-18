@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="text-secondary mt-2">Cadastro Pessoa Jurídica</h1>
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
        <div>
            <a href="{{route('legalPerson.create')}}" class="btn btn-success my-2"> + Cadastrar Pessoa Jurídica</a>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Usuário</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($legalPerson as $person)
                    <tr>
                            <td>{{$person->id}}</td>
                            <td>{{$person->corporate_name}}</td>
                            <td class="d-flex">
                                <a class="mr-3 btn btn-sm btn-outline-success" href="{{route('legalPerson.edit', ['legalPerson' => $person->id])}}">Editar</a>
                                <form action="{{route('legalPerson.destroy', ['legalPerson'=> $person->id])}}" method="post">
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
