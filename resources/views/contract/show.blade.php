@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="text-secondary mt-2">Contrato Nº {{$contract->id}}</h1>
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
            <a href="{{route('contract.index')}}" class="btn btn-success my-2"> Voltar</a>
        </div>
        <div class="mt-5">
            <h3 class="text-secondary">Tipo de Pessoa: {{$contract->type_person}}</h3>
            <h3 class="text-secondary">Tipo de Contrato: {{$contract->type_contract}}</h3>
            <h3 class="text-secondary">Contratante: {{$contract->name_contractor}}</h3>
            <h3 class="text-secondary">CPF/CNPJ: {{$contract->cpf ?? $contract->cnpj}}</h3>
        </div>
        <div>
            <hr>
            <h2 class="text-secondary text-center">Lojas</h2>
            <div>
                <form action="" method="post" class="mt-4 row" autocomplete="off">
                    @csrf
                    <div class="col-6">
                        <label for="id_store" id="id_store" class="text-secondary">Loja</label>
                        <select name="id_store" id="id_store" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($stores as $store)
                                <option value="{{$store->id}}">{{$store->name}}</option>
                            @endforeach
                        </select>
                        @error('id_store')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-6">
                        <label for="price_store" class="text-secondary">Valor</label>
                        <input type="text" class="form-control @error('store_price') is-invalid @enderror" id="store_price"
                            placeholder="Insira o valor da loja" name="store_price" value="{{ old('store_price') }}">
                        @error('store_price')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-block btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
