@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="my-4 text-secondary text-center"> Cadastro Pessoa Física</h2>
            </div>
            <div class="">
                <form action="{{route('legalPerson.update', ['legalPerson' => $legalPerson->id])}}" method="post" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <label for="corporate_name" class="text-secondary">Razão Social</label>
                            <input type="text" class="form-control @error('corporate_name') is-invalid @enderror" id="corporate_name"
                                placeholder="Ex: Empresa LTDA" name="corporate_name" value="{{ old('corporate_name') ?? $legalPerson->corporate_name }}">
                            @error('corporate_name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fantasy_name" class="text-secondary">Nome Fantasia</label>
                            <input type="text" class="form-control @error('fantasy_name') is-invalid @enderror" id="fantasy_name"
                            placeholder="Ex: Empresa" name="fantasy_name" value="{{ old('fantasy_name') ?? $legalPerson->fantasy_name}}">
                            @error('fantasy_name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="text-secondary">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                placeholder="Ex: email@email.com.br" name="email" value="{{ old('email') ?? $legalPerson->email}}">
                            @error('email')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="telephone" class="text-secondary">Telefone</label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone"
                                placeholder="Ex: 987000000" name="telephone" value="{{ old('telephone') ?? $legalPerson->telephone }}">
                            @error('telephone')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cnpj" class="text-secondary">CNPJ</label>
                            <input type="text" class="form-control @error('cnpj') is-invalid @enderror" id="cnpj"
                                placeholder="Ex: 99.999.999/9999-99" name="cnpj" value="{{ old('cnpj') ?? $legalPerson->cnpj}}">
                            @error('cnpj')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cep" class="text-secondary">CEP</label>
                            <input type="text" class="form-control @error('cep') is-invalid @enderror" id="cep"
                                placeholder="Ex: 60000-000" name="cep" value="{{ old('cep') ?? $legalPerson->cep}}">
                            @error('cep')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-10">
                            <label for="public_place" class="text-secondary">Endereço</label>
                            <input type="text" class="form-control @error('public_place') is-invalid @enderror" id="public_place"
                                placeholder="Ex: Rua A" name="public_place" value="{{ old('public_place') ?? $legalPerson->public_place}}">
                            @error('public_place')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="nr_public_place" class="text-secondary">Nº</label>
                            <input type="number" class="form-control @error('nr_public_place') is-invalid @enderror" id="nr_public_place"
                                placeholder="Ex: 9999" name="nr_public_place" value="{{ old('nr_public_place') ?? $legalPerson->nr_public_place}}">
                            @error('nr_public_place')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="text-secondary">Cidade</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                                placeholder="Ex: Fortaleza" name="city" value="{{ old('city') ?? $legalPerson->city}}">
                            @error('city')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="text-secondary">Estado</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" id="state"
                                placeholder="Ex: Ceará" name="state" value="{{ old('state') ?? $legalPerson->state}}">
                            @error('state')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-4">
                            <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                            <a href="{{route('legalPerson.index')}}" class="btn btn-lg btn-danger">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
    </div>
@endsection
