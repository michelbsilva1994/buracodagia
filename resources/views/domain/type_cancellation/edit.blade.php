@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2">
            <div class="col-12">
                <h2 class="my-4 text-secondary text-center">{{$typeCancellation->description}}</h2>
            </div>
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
                <form action="{{ route('typeCancellation.update', ['typeCancellation' => $typeCancellation->id]) }}" method="post" class="col-sm-12 col-md-10 col-lg-6" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="col-sm-12 col-md-2">
                        <label for="value" class="text-secondary">Valor</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" id="value"
                            name="value" value="{{ old('value') ?? $typeCancellation->value }}">
                        @error('value')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label for="description" class="text-secondary">Descrição</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" value="{{ old('description') ?? $typeCancellation->description}}">
                        @error('description')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="statusA" value="A" @if ($typeCancellation->status == 'A') checked @endif>
                            <label class="form-check-label" for="statusA">Ativo</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="statusI" value="I" @if ($typeCancellation->status == 'I') checked @endif>
                            <label class="form-check-label" for="statusI">Inativo</label>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-block btn-success">Salvar</button>
                        <a href="{{route('typeCancellation.index')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
