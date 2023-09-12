@extends('layout.app')
@section('content')
    <div class="container">
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
        <form action="{{route('monthly.store')}}" method="post" class="mt-5">
            @csrf
            <div class="row d-flex justify-content-center">
                <div class="col-8">
                    <label for="due_date" class="form-label">Data de Vencimento</label>
                    <input type="date" name="due_date" id="due_date" class="form-control">
                </div>
                <div class="col-8 mt-2 d-grid gap-2">
                    <button type="submit" class="btn btn-success ">Gerar Mensalidades</button>
                </div>
            </div>
        </form>
    </div>
@endsection
