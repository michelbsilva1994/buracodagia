@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2 col-8">
            <div class="col-8">
                <h2 class="text-secondary mt-2"> Alterar Status Loja</h2>
            </div>
            <div class="col-8">
                <form action="{{ route('storeStatus.update', ['storeStatus' => $status->id]) }}" method="post" class="mt-4 row" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="col-2">
                        <label for="value" class="text-secondary">Valor</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" id="value"
                            name="value" value="{{ old('value') ?? $status->value }}">
                        @error('value')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-10">
                        <label for="description" class="text-secondary">Descrição</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" value="{{ old('description') ?? $status->description}}">
                        @error('description')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="A" @if ($status->status == 'A') checked @endif>
                            <label class="form-check-label" for="status">Ativo</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="I" @if ($status->status == 'I') checked @endif>
                            <label class="form-check-label" for="status">Inativo</label>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-block btn-success">Salvar</button>
                        <a href="{{route('storeStatus.index')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
