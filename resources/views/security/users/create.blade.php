@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2">
            <div class="col-12">
                <h2 class="my-4 text-secondary text-center">Cadastrar Usuário</h2>
            </div>
            <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
                <form action="{{ route('user.store') }}" method="post" class="col-sm-12 col-md-10 col-lg-6" autocomplete="off">
                    @csrf
                    <div class="col-sm-12 col-md-12">
                        <label for="physical_person" class="text-secondary">Pessoa Física</label>
                        <select name="physical_person" id="physical_person" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($physicalPeople as $physicalPerson)
                                <option value="{{$physicalPerson->id}}">{{$physicalPerson->name}}</option>
                            @endforeach
                        </select>
                        @error('physical_person')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <fieldset>
                        <label for="type_user" class="form-check-label text-secondary">Tipo de Usuário</label>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_user" id="typeUserU" value="U" checked>
                                <label class="form-check-label" for="typeUserU">Usuário</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_user" id="typeUserE" value="E">
                                <label class="form-check-label" for="typeUserE">Executor</label>
                            </div>
                        </div>
                    </fieldset>
                    <div class="col-md-12 col-md-12">
                        <label for="name" class="text-secondary">Usuário</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Insira o Nome do Usuário" name="name" value="{{ old('name') }}">
                        @error('name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 col-md-12">
                        <label for="email" class="text-secondary">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="Insira email do usuário" name="email" value="{{ old('email') }}">
                        @error('email')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 col-md-12">
                        <label for="password" class="text-secondary">Senha</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            placeholder="Insira uma senha" name="password" value="{{ old('password') }}">
                        @error('password')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end my-4">
                        <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                        <a href="{{route('user.index')}}" class="btn btn-lg btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
