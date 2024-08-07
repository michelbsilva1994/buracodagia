@extends('layout.app')
@section('content')
    <div class="container">
        <div class="">
            <div class="mt-2">
            <div class="col-12">
                <h2 class="my-4 text-secondary text-center">Cadastrar Pavimento</h2>
            </div>
            <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
                <form action="{{ route('equipment.store') }}" method="post" class="col-sm-12 col-md-10 col-lg-6" autocomplete="off">
                    @csrf
                    <div class="col-sm-12 col-md-12">
                        <label for="name" class="text-secondary">Equipamento</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Insira o Nome do Equipamento" name="name" value="{{ old('name') }}">
                        @error('name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="A" checked>
                            <label class="form-check-label" for="status">Ativo</label>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <input class="form-check-input" type="radio" name="status" value="I">
                            <label class="form-check-label" for="status">Inativo</label>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                        <a href="{{route('equipment.index')}}" class="btn btn-lg btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
