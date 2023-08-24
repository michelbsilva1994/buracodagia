@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2 col-8">
            <div class="col-8">
                <h2 class="text-secondary mt-2"> Cadastro Contrato</h2>
            </div>
            <div class="col-12">
                <form class="row" action="{{route('contract.store')}}" method="post" class="mt-4" autocomplete="off">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_person" id="type_person_pf" value="PF" checked>
                            <label class="form-check-label" for="type_person_pf">PF</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_person" id="type_person_pj" value="PJ">
                            <label class="form-check-label" for="type_person_pj">PJ</label>
                        </div>
                    </div>
                    <div class="col-md-12" id="info_person">
                        <label for="id_physical_person" id="id_physical_person_label" class="text-secondary">Contratante</label>
                        <select name="id_person" id="id_physical_person" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                                    @foreach($physicalPerson as $person)
                                        <option value="{{$person->id}}">{{$person->name}}</option>
                                    @endforeach
                        </select>
                        @error('id_person')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="type_contract" class="text-secondary">Tipo de contrato</label>
                        <select name="type_contract" id="type_contract" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($typeContracts as $typeContract)
                                <option value="{{$typeContract->value}}">{{$typeContract->description}}</option>
                            @endforeach
                        </select>
                        @error('type_contract')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="dt_contraction" class="text-secondary">Data inicial do contrato</label>
                        <input type="date" class="form-control" name="dt_contraction" id="dt_contraction">
                        @error('dt_contraction')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
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

            $('#info_person').append('<label for="id_legal_person" id="id_legal_person_label" class="text-secondary">Contratante</label>'+
                                     '<select name="id_person" id="id_legal_person" class="form-select">'+
                                     '<option selected disabled>Selecione uma opção</option>'+
                                     '@foreach($legalPerson as $person)'+
                                     '<option value="{{$person->id}}">{{$person->fantasy_name}}</option>'+
                                     '@endforeach'+
                                     '</select>');
        });
        $("#type_person_pf").click(function(){
            $('#id_physical_person_label').remove();
            $('#id_physical_person').remove();
            $('#id_legal_person_label').remove();
            $('#id_legal_person').remove();

            $('#info_person').append('<label for="id_physical_person" id="id_physical_person_label" class="text-secondary">Contratante</label>'+
                                     '<select name="id_person" id="id_physical_person" class="form-select">'+
                                     '<option selected disabled>Selecione uma opção</option>'+
                                     '@foreach($physicalPerson as $person)'+
                                        '<option value="{{$person->id}}">{{$person->name}}</option>'+
                                     '@endforeach'+
                                     '</select>');
        });
    </script>
@endsection
