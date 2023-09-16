@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h3 class="my-4 text-secondary text-center">Geração de Mensalidades</h3>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('alert'))
            <div class="alert alert-warning" role="alert">
                {{ session('alert') }}
            </div>
        @endif
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-">
            <form action="{{route('monthly.store')}}" method="post" class="col-sm-12 col-md-12 col-lg-10">
                @csrf
                    <div class="col-sm-12 col-md-8 mx-auto">
                        <label for="due_date" class="form-label">Data de Vencimento</label>
                        <input type="date" name="due_date" id="due_date" class="form-control">
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center my-2">
                        <button type="submit" class="btn btn-lg btn-success">Gerar Mensalidades</button>
                    </div>
            </form>
        </div>
    </div>
@endsection
