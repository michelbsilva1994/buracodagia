@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2 col-8">
            <div class="col-8">
                <h2 class="text-secondary mt-2"> Cadastrar Tipo Contrato</h2>
            </div>
            <div class="col-8">
                <form action="{{ route('typeContract.update', ['typeContract'=>$typeContract->id]) }}" method="post" class="mt-4 row" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <label for="description" class="text-secondary">Descrição</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" value="{{ old('description') ?? $typeContract->description}}">
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
