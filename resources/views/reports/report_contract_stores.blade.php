@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Relatório Contratos</h3>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form action="{{route('reports.reportContractStores')}}" method="post" class="col-sm-12 col-md-12 col-lg-12">
                @csrf
                <div class="row">
                    {{-- <div class="col-sm-12 col-md-12 col-lg-12">
                        <label for="corporate_name">Nome</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div> --}}
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="signed">Assinados</label>
                        <select name="signed" id="signed" class="form-control">
                            <option value="1">Todos</option>
                            <option value="2">Assinados</option>
                            <option value="3">Não Assinados</option>
                        </select>
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
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-center my-3">
                        <button type="submit" class="btn btn-lg btn-success">Gerar Relatório</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
