@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2 col-8">
            <div class="col-8">
                <h2 class="text-secondary mt-2">Cadastrar Pavimento</h2>
            </div>
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-8">
                <form action="{{ route('pavement.store') }}" method="post" class="mt-4" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="text-secondary">Pavimento</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Insira o Nome do Pavimento" name="name" value="{{ old('name') }}">
                        @error('name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="A" checked>
                            <label class="form-check-label" for="status">Ativo</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="I">
                            <label class="form-check-label" for="status">Inativo</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="text-secondary">Descrição</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{old('description')}}</textarea>
                        @error('description')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-block btn-success">Salvar</button>
                        <a href="{{route('pavement.index')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
