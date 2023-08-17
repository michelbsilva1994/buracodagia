@extends('layout.app')
@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('status') }}
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
