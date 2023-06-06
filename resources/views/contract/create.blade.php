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
                            <input class="form-check-input" type="radio" name="type_person" id="type_person_pf" value="PF" checked>
                            <label class="form-check-label" for="type_person">PF</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_person" id="type_person_pj" value="PJ">
                            <label class="form-check-label" for="type_person">PJ</label>
                        </div>
                    </div>
                    <div class="col-md-12" id="info_person">
                        <label for="id_physical_person" id="id_physical_person_label" class="text-secondary">Pessoa Física</label>
                        <select name="id_physical_person" id="id_physical_person" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                                    @foreach($physicalPerson as $person)
                                        <option value="{{$person->id}}">{{$person->name}}</option>
                                    @endforeach
                        </select>
                        @error('id_physical_person')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-block btn-success">Salvar</button>
                        <a href="{{route('contract.index')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $("#type_person_pj").click(function(){
            $('#id_physical_person_label').remove();
            $('#id_physical_person').remove();

            $('#info_person').append('<label for="id_physical_person" id="id_legal_person_label" class="text-secondary">Pessoa Jurídica</label>'+
                                     '<select name="id_legal_person" id="id_legal_person" class="form-select">'+
                                     '<option selected disabled>Selecione uma opção</option><option value="1">Pessoa Jurídica</option></select>');
        });
        $("#type_person_pf").click(function(){
            $('#id_physical_person_label').remove();
            $('#id_physical_person').remove();
            $('#id_legal_person_label').remove();
            $('#id_legal_person').remove();

            $('#info_person').append('<label for="id_physical_person" id="id_physical_person_label" class="text-secondary">Pessoa Física</label>'+
                                     '<select name="id_physical_person" id="id_physical_person" class="form-select">'+
                                     '<option selected disabled>Selecione uma opção</option>'+
                                     '@foreach($physicalPerson as $person)'+
                                        '<option value="{{$person->id}}">{{$person->name}}</option>'+
                                     '@endforeach'+
                                     '</select>');
        });
    </script>
@endsection
