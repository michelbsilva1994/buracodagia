@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2 col-8">
            <div class="col-8">
                <h2 class="text-secondary mt-2"> Cadastrar Usuário</h2>
            </div>
            <div class="col-8">
                <form action="{{ route('user.store') }}" method="post" class="mt-4" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="text-secondary">Usuário</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Insira o Nome do Usuário" name="name" value="{{ old('name') }}">
                        @error('name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="text-secondary">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="Insira email do usuário" name="email" value="{{ old('email') }}">
                        @error('email')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="password" class="text-secondary">Senha</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            placeholder="Insira o Nome do Perfil" name="password" value="{{ old('password') }}">
                        @error('password')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-block btn-success">Salvar</button>
                        <a href="{{route('user.index')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
