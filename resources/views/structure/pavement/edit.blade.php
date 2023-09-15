@extends('layout.app')
@section('content')
    <div class="container">
        <div class="">
            <div class="mt-2">
            <div class="col-12">
                <h2 class="my-4 text-secondary text-center">Editar Pavimento</h2>
            </div>
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
                <form action="{{ route('pavement.update', ['pavement' => $pavement->id]) }}" method="post" class="col-sm-12 col-md-10 col-lg-6" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="col-sm-12 col-md-12">
                        <label for="name" class="text-secondary">Pavimento</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Insira o Nome do Pavimento" name="name" value="{{ old('name') ?? $pavement->name }}">
                        @error('name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="A" @if ($pavement->status == 'A') checked @endif>
                            <label class="form-check-label" for="status">Ativo</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="I" @if ($pavement->status == 'I') checked @endif>
                            <label class="form-check-label" for="status">Inativo</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label for="description" class="text-secondary">Descrição</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{old('description') ?? $pavement->description}}</textarea>
                        @error('description')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                        <a href="{{route('pavement.index')}}" class="btn btn-lg btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
