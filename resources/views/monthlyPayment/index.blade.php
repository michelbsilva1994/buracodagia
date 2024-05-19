@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h3 class="my-4 text-secondary text-center">Geração de Mensalidades</h3>
        </div>
        <div class="col-sm-12 d-md-flex justify-content-md-center">
            <form action="{{route('monthly.store')}}" method="post" class="col-sm-12 col-md-12 col-lg-10">
                @csrf
                    <div class="col-sm-12 col-md-8 mx-auto">
                        <label for="due_date" class="form-label">Data de Vencimento</label>
                        <input type="date" name="due_date" id="due_date" class="form-control">
                        @error('due_date')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-8 mx-auto">
                        <label for="pavement">Pavimento</label>
                        <select name="pavement" id="pavement" class="form-control">
                            <option value="">Selecione uma opção</option>
                            @foreach ( $pavements as $pavement)
                                <option value="{{$pavement->id}}">{{$pavement->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center my-3">
                        <button type="submit" class="btn btn-lg btn-success">Gerar Mensalidades</button>
                    </div>
            </form>
        </div>
    </div>
@endsection
