@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2">
            <div class="col-12">
                <h2 class="my-4 text-secondary text-center">Cadastrar Tipo Loja</h2>
            </div>
            <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
                <form action="{{ route('storeType.store') }}" method="post" class="col-sm-12 col-md-10 col-lg-6" autocomplete="off">
                    @csrf
                    <div class="col-sm-12 col-md-2">
                        <label for="value" class="text-secondary">Valor</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" id="value"
                            name="value" value="{{ old('value')}}">
                        @error('value')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label for="description" class="text-secondary">Descrição</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" value="{{ old('description') }}">
                        @error('description')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="A" checked>
                            <label class="form-check-label" for="status">Ativo</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="I">
                            <label class="form-check-label" for="status">Inativo</label>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end my-4">
                        <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                        <a href="{{route('storeType.index')}}" class="btn bnt-lg btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
