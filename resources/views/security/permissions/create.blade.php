@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2">
            <div class="col-12">
                <h2 class="my-4 text-secondary text-center"> Cadastrar Permissão</h2>
            </div>
            <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
                <form action="{{ route('permission.store') }}" method="post" class="col-sm-12 col-md-10 col-lg-6" autocomplete="off">
                    @csrf
                    <div class="col-sm-12 col-md-12">
                        <label for="name" class="text-secondary">Permissão</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Insira o nome do permissão" name="name" value="{{ old('name') }}">
                        @error('name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end my-4">
                        <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                        <a href="{{route('permission.index')}}" class="btn btn-lg btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
