@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2">
            <div class="col-12">
                <h2 class="my-4 text-secondary text-center">Cadastrar Loja</h2>
            </div>
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
                <form action="{{ route('store.store') }}" method="post" class="col-sm-12 col-md-10 col-lg-6" autocomplete="off">
                    @csrf
                    <div class="col-sm-12 col-md-10">
                        <label for="name" class="text-secondary">Loja</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Insira o nome da Loja" name="name" value="{{ old('name') }}">
                        @error('name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-10">
                        <label for="status" class="text-secondary">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($storeStatues as $storeStatus)
                                <option value="{{$storeStatus->value}}">{{$storeStatus->description}}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label for="type" class="text-secondary">Tipo da Loja</label>
                        <select name="type" id="type" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($storeType as $type)
                                <option value="{{$type->value}}">{{$type->description}}</option>
                            @endforeach
                        </select>
                        @error('type')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label for="id_pavement" class="text-secondary">Pavimento</label>
                        <select name="id_pavement" id="id_pavement" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($pavementies as $pavement)
                                <option value="{{$pavement->id}}">{{$pavement->name}}</option>
                            @endforeach
                        </select>
                        @error('id_pavement')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label for="description" class="text-secondary">Descrição</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{old('description')}}</textarea>
                        @error('description')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end my-4">
                        <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                        <a href="{{route('store.index')}}" class="btn btn-lg btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
