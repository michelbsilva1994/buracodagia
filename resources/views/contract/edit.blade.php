@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-2 col-8">
            <div class="col-8">
                <h2 class="text-secondary mt-2"> Cadastro Contrato</h2>
            </div>
            <div class="col-12">
                <form class="row" action="{{route('contract.update', ['contract' => $contract->id])}}" method="post" class="mt-4" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_person" id="type_person_pf" value="PF" @if($contract->type_person === 'PF') checked @endif>
                            <label class="form-check-label" for="type_person">PF</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_person" id="type_person_pj" value="PJ" @if($contract->type_person === 'PJ') checked @endif>
                            <label class="form-check-label" for="type_person">PJ</label>
                        </div>
                    </div>
                    <div class="col-md-12" id="info_person">
                        <label for="id_physical_person" id="id_physical_person_label" class="text-secondary">Pessoa Física</label>
                        <select name="id_physical_person" id="id_physical_person" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                        </select>
                        @error('id_physical_person')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="type_contract" class="text-secondary">Tipo de contrato</label>
                        <select name="type_contract" id="type_contract" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($typeContracts as $typeContract)
                                <option value="{{$typeContract->value}}" @if($typeContract->value === $contract->type_contract) selected @endif>{{$typeContract->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="dt_contraction" class="text-secondary">Data inicial do contrato</label>
                        <input type="date" class="form-control" name="dt_contraction" id="dt_contraction" value="{{$contract->dt_contraction}}">
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
        $(document).ready(function(){
            let type_person_pj = $('#type_person_pj').prop('checked');
            let type_person_pf = $('#type_person_pf').prop('checked');

            if(type_person_pj == true){
                $('#id_physical_person_label').remove();
                $('#id_physical_person').remove();

                $('#info_person').append('<label for="id_physical_person" id="id_legal_person_label" class="text-secondary">Pessoa Jurídica</label>'+
                                     '<select name="id_legal_person" id="id_legal_person" class="form-select">'+
                                     '<option selected disabled>Selecione uma opção</option>'+
                                     '@foreach($legalPerson as $person)'+
                                     '<option value="{{$person->id}}" @if($person->id === $contract->id_legal_person) selected @endif>{{$person->fantasy_name}}</option>'+
                                     '@endforeach'+
                                     '</select>')
            }
            if(type_person_pf == true){
                $('#id_physical_person_label').remove();
                $('#id_physical_person').remove();
                $('#id_legal_person_label').remove();
                $('#id_legal_person').remove();

                $('#info_person').append('<label for="id_physical_person" id="id_physical_person_label" class="text-secondary">Pessoa Física</label>'+
                                     '<select name="id_physical_person" id="id_physical_person" class="form-select">'+
                                     '<option selected disabled>Selecione uma opção</option>'+
                                     '@foreach($physicalPerson as $person)'+
                                        '<option value="{{$person->id}}" @if($person->id === $contract->id_physical_person) selected @endif>{{$person->name}}</option>'+
                                     '@endforeach'+
                                     '</select>')
            }
        });

        $("#type_person_pj").click(function(){
            $('#id_physical_person_label').remove();
            $('#id_physical_person').remove();

            $('#info_person').append('<label for="id_physical_person" id="id_legal_person_label" class="text-secondary">Pessoa Jurídica</label>'+
                                     '<select name="id_legal_person" id="id_legal_person" class="form-select">'+
                                     '<option selected disabled>Selecione uma opção</option>'+
                                     '@foreach($legalPerson as $person)'+
                                     '<option value="{{$person->id}}" @if($person->id === $contract->id_legal_person) selected @endif>{{$person->fantasy_name}}</option>'+
                                     '@endforeach'+
                                     '</select>');
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
                                        '<option value="{{$person->id}}" @if($person->id === $contract->id_physical_person) selected @endif>{{$person->name}}</option>'+
                                     '@endforeach'+
                                     '</select>');
        });
    </script>
@endsection
