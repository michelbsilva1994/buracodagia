@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2 col-8">
            <div class="col-8">
                <h2 class="text-secondary mt-2"> Cadastrar Tipo Contrato</h2>
            </div>
            <div class="col-8">
                <form action="{{ route('typeContract.store') }}" method="post" class="mt-4 row" autocomplete="off">
                    @csrf
                    <div class="col-md-3">
                        <label for="value" class="text-secondary">Valor</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" id="value"
                            name="value" value="{{ old('value') }}">
                        @error('value')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-9">
                        <label for="description" class="text-secondary">Descrição</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" value="{{ old('description') }}">
                        @error('description')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-block btn-success">Salvar</button>
                        <a href="{{route('typeContract.index')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
