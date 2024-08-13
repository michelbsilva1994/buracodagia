@extends('layout.app')
@section('content')
    <div class="container">
        <h3 class="my-4 text-secondary text-center">Relatório Baixas</h3>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form action="{{route('reports.lowersTuition')}}" method="post" class="col-sm-12 col-md-12 col-lg-12">
                <div class="col-sm-12 col-md-12 col-lg-12 row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_initial">Data Baixa Inicial</label>
                        <input type="date" name="due_date_initial" id="due_date_initial" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_final">Data Baixa Final</label>
                        <input type="date" name="due_date_final" id="due_date_final" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="pavement">Pavimento</label>
                        <select name="pavement" id="pavement" class="form-control">
                            <option value="">Selecione uma opção</option>
                            @foreach ( $pavements as $pavement)
                                <option value="{{$pavement->id}}">{{$pavement->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @csrf
                <div class="row">
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-center my-3">
                        <button type="submit" class="btn btn-lg btn-success">Gerar Relatório</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
