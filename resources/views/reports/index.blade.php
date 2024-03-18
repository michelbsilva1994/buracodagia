@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Relatório Usuários</h3>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form action="{{route('reports.users')}}" method="post" class="col-sm-12 col-md-12 col-lg-12">
                @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label for="corporate_name">Nome</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                        <button type="submit" class="btn btn-lg btn-success">Gerar Relatório</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
