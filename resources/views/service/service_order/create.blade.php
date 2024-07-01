@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2">
            <div class="col-12">
                <h2 class="my-4 text-secondary text-center"> Ordem de Serviço</h2>
            </div>
            <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
                <form action="{{route('serviceOrders.store')}}" method="post" class="col-sm-12 col-md-10 col-lg-6" autocomplete="off">
                    @csrf
                    <div class="col-sm-12 col-md-12">
                        <label for="requester" class="text-secondary">Solicitante</label>
                        <input type="text" class="form-control" id="requester"
                            name="requester" value="{{ $requester->name }}" readonly>
                        <input type="hidden" class="form-control" id="id_requester"
                            name="id_requester" value="{{ $requester->id }}">
                        @error('requester')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label for="location" class="text-secondary">Localização</label>
                        <select name="location" id="location" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($locations as $location)
                                <option value="{{$location->id_store}}">{{$location->store}} - {{$location->pavement}}</option>
                            @endforeach
                        </select>
                        @error('location')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label for="equipment" class="text-secondary">Equipamento</label>
                        <select name="equipment" id="equipment" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($equipments as $equipment)
                                <option value="{{$equipment->id}}">{{$equipment->name}}</option>
                            @endforeach
                        </select>
                        @error('equipment')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label for="title" class="text-secondary">Título</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}">
                        @error('title')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label for="description" class="text-secondary">Descrição</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{old('description')}}</textarea>
                        @error('description')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <fieldset>
                        <label for="status" class="form-check-label text-secondary">Status</label>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusA" value="A" checked disabled>
                                <label class="form-check-label" for="statusA">Aberta</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusP" value="P" disabled>
                                <label class="form-check-label" for="statusP">Processo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusF" value="F" disabled>
                                <label class="form-check-label" for="statusF">Fechada</label>
                            </div>
                        </div>
                    </fieldset>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end my-4">
                        <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                        <a href="" class="btn btn-lg btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
