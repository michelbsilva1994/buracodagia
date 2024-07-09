@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 my-2">
                <h2 class="my-4 text-secondary text-center">Cadastro Pessoa Física</h2>
            </div>
            <div class="col-sm-12 col-12 d-lg-flex justify-content-lg-center mx-auto">
                <form action="{{ route('physicalPerson.store') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <label for="name" class="text-secondary">Nome</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Ex: João Silva" name="name" value="{{ old('name') }}">
                            @error('name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="birth_date" class="text-secondary">Data Nascimento</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                                name="birth_date" value="{{ old('birth_date') }}">
                            @error('birth_date')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="text-secondary">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                placeholder="Ex: email@email.com.br" name="email" value="{{ old('email') }}">
                            @error('email')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cpf" class="text-secondary">CPF</label>
                            <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf"
                                placeholder="Ex: 999.999.999-99" data-mask="000.000.000-00" name="cpf" value="{{ old('cpf') }}">
                            @error('cpf')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="rg" class="text-secondary">RG</label>
                            <input type="text" class="form-control @error('rg') is-invalid @enderror" id="rg"
                                placeholder="Ex: 9999999999" name="rg" value="{{ old('rg') }}">
                            @error('rg')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="telephone" class="text-secondary">Telefone</label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone"
                                placeholder="Ex: (85) 98700-0000" data-mask="(00) 00000-0000" name="telephone" value="{{ old('telephone') }}">
                            @error('telephone')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cep" class="text-secondary">CEP</label>
                            <input type="text" class="form-control @error('cep') is-invalid @enderror" id="cep"
                                placeholder="Ex: 60000-000" data-mask="00000-000" name="cep" value="{{ old('cep') }}">
                            @error('cep')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-10">
                            <label for="public_place" class="text-secondary">Endereço</label>
                            <input type="text" class="form-control @error('public_place') is-invalid @enderror" id="public_place"
                                placeholder="Ex: Rua A" name="public_place" value="{{ old('public_place') }}">
                            @error('public_place')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="nr_public_place" class="text-secondary">Nº</label>
                            <input type="number" class="form-control @error('nr_public_place') is-invalid @enderror" id="nr_public_place"
                                placeholder="Ex: 9999" name="nr_public_place" value="{{ old('nr_public_place') }}">
                            @error('nr_public_place')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="text-secondary">Cidade</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                                placeholder="Ex: Fortaleza" name="city" value="{{ old('city') }}">
                            @error('city')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="text-secondary">Estado</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" id="state"
                                placeholder="Ex: Ceará" name="state" value="{{ old('state') }}">
                            @error('state')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="mt-1">
                            <div class="form-check">
                                <label class="form-check-label" for="contract_create">Criar contrato ao salvar</label>
                                <input type="checkbox" class="form-check-input" id="contract_create" name="contract_create" checked>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-4">
                            <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                            <a href="{{route('physicalPerson.index')}}" class="btn btn-lg btn-danger">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
    </div>
@endsection
