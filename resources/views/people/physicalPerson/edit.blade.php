@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2 col-8">
            <div class="col-8">
                <h2 class="text-secondary mt-2"> Cadastro Pessoa Física</h2>
            </div>
            <div class="col-12">
                <form class="row" action="{{ route('physicalPerson.update', ['physicalPerson'=>$physicalPerson->id]) }}" method="post" class="mt-4" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">
                        <label for="name" class="text-secondary">Nome</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Ex: João Silva" name="name" value="{{ old('name') ?? $physicalPerson->name }}">
                        @error('name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="birth_date" class="text-secondary">Data Nascimento</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                            name="birth_date" value="{{ old('birth_date') ?? $physicalPerson->birth_date }}">
                        @error('birth_date')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="text-secondary">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="Ex: email@email.com.br" name="email" value="{{ old('email') ?? $physicalPerson->email }}">
                        @error('email')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="cpf" class="text-secondary">CPF</label>
                        <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf"
                            placeholder="Ex: 999.999.999-99" name="cpf" value="{{ old('cpf') ?? $physicalPerson->cpf }}">
                        @error('cpf')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="rg" class="text-secondary">RG</label>
                        <input type="text" class="form-control @error('rg') is-invalid @enderror" id="rg"
                            placeholder="Ex: 9999999999" name="rg" value="{{ old('rg') ?? $physicalPerson->rg }}">
                        @error('rg')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="telephone" class="text-secondary">Telefone</label>
                        <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone"
                            placeholder="Ex: 987000000" name="telephone" value="{{ old('telephone') ?? $physicalPerson->telephone }}">
                        @error('telephone')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="cep" class="text-secondary">CEP</label>
                        <input type="text" class="form-control @error('cep') is-invalid @enderror" id="cep"
                            placeholder="Ex: 60000-000" name="cep" value="{{ old('cep') ?? $physicalPerson->cep }}">
                        @error('cep')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-10">
                        <label for="public_place" class="text-secondary">Endereço</label>
                        <input type="text" class="form-control @error('public_place') is-invalid @enderror" id="public_place"
                            placeholder="Ex: Rua A" name="public_place" value="{{ old('public_place') ?? $physicalPerson->public_place }}">
                        @error('public_place')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="nr_public_place" class="text-secondary">Nº</label>
                        <input type="number" class="form-control @error('nr_public_place') is-invalid @enderror" id="nr_public_place"
                            placeholder="Ex: 9999" name="nr_public_place" value="{{ old('nr_public_place') ?? $physicalPerson->nr_public_place }}">
                        @error('nr_public_place')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="city" class="text-secondary">Cidade</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                            placeholder="Ex: Fortaleza" name="city" value="{{ old('city') ?? $physicalPerson->city }}">
                        @error('city')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="state" class="text-secondary">Estado</label>
                        <input type="text" class="form-control @error('state') is-invalid @enderror" id="state"
                            placeholder="Ex: Ceará" name="state" value="{{ old('state') ?? $physicalPerson->state }}">
                        @error('state')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-block btn-success">Salvar</button>
                        <a href="{{route('physicalPerson.index')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
