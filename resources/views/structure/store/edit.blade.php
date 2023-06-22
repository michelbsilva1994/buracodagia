@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2 col-8">
            <div class="col-8">
                <h2 class="text-secondary mt-2">Cadastrar Loja</h2>
            </div>
            <div class="col-8">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('store.update', ['store' => $store->id]) }}" method="post" class="mt-4" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name" class="text-secondary">Loja</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Insira o nome da Loja" name="name" value="{{ old('name') ?? $store->name}}">
                        @error('name')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="status" class="text-secondary">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($storeStatues as $storeStatus)
                                <option value="{{$storeStatus->value}}" @if($store->value === $storeStatus->value) selected @endif>{{$storeStatus->description}}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="type" class="text-secondary">Tipo da Loja</label>
                        <select name="type" id="type" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($storeType as $type)
                                <option value="{{$type->value}}" @if($store->type === $type->value) selected @endif>{{$type->description}}</option>
                            @endforeach
                        </select>
                        @error('type')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_pavement" class="text-secondary">Pavimento</label>
                        <select name="id_pavement" id="id_pavement" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($pavementies as $pavement)
                                <option value="{{$pavement->id}}" @if($store->id_pavement === $pavement->id) selected @endif>{{$pavement->name}}</option>
                            @endforeach
                        </select>
                        @error('id_pavement')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="description" class="text-secondary">Descrição</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{$store->description}}</textarea>
                        @error('description')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-block btn-success">Salvar</button>
                        <a href="{{route('store.index')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
