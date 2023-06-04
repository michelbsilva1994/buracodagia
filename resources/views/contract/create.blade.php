@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2 col-8">
            <div class="col-8">
                <h2 class="text-secondary mt-2"> Cadastro Pessoa Física</h2>
            </div>
            <div class="col-12">
                <form class="row" action="{{route('contract.store')}}" method="post" class="mt-4" autocomplete="off">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_person" value="PF" checked>
                            <label class="form-check-label" for="type_person">PF</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_person" value="PJ">
                            <label class="form-check-label" for="type_person">PJ</label>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-block btn-success">Salvar</button>
                        <a href="{{route('contract.index')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
