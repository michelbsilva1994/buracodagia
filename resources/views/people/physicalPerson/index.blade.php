@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h3 class="my-4 text-secondary text-center">Cadastro Pessoa Física</h3>
        </div>
        <div id="message-delete"></div>
        <div class="d-grid gap-2 d-lg-flex justify-content-lg-start my-3">
            <a href="{{route('physicalPerson.create')}}" class="btn btn-lg btn-success"> + Cadastrar Pessoal Física</a>
        </div>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form action="{{route('physical.filter')}}" method="get" class="col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{request('filtroNome')}}">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" data-mask="000.000.000-00" value="{{request('filtroCPF')}}">
                    </div>
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                        <button type="submit" class="btn btn-lg btn-success">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 table-responsive mt-2">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Usuário</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($physicalPeople as $person)
                    <tr id="person-{{$person->id}}">
                            <td>{{$person->id}}</td>
                            <td>{{$person->name}}</td>
                            <td class="d-flex">
                                <a class="mr-3 btn btn-sm btn-outline-success" href="{{route('physicalPerson.edit', ['physicalPerson'=>$person->id])}}">Editar</a>
                                <a class="mr-3 btn btn-sm btn-outline-success" href="{{route('physical.contractPerson', ['id_person'=>$person->id])}}">Contrato</a>
                                <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-delete" data-id-person="{{$person->id}}" data-bs-toggle="modal" data-bs-target="#modal-delete">Excluir</a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center my-2">
            {{ $physicalPeople->appends(request()->input())->links()}}
        </div>

    </div>
    <div class="modal fade" id="modal-delete" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel">Excluir</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Tem certeza que deseja excluir o registro?
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_person" id="id_person">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-destroy">Excluir</button>
            </div>
          </div>
        </div>
    </div>
    <script>
        $(document).delegate('#btn-delete', 'click', function(){
            var id_person = $(this).attr('data-id-person');
            $('#id_person').val(id_person);
        });
        $(document).delegate('#btn-destroy','click', function(){
            var id_person = $('#id_person').val();

            $.ajax({
                url: '/public/physicalPerson/'+id_person,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    $('#message-delete').html(response.status);
                    $('#modal-delete').modal('hide');
                    $('#message-delete').addClass('alert alert-success').show();
                    $('#person-'+id_person).remove();
                    $('#message-delete').fadeOut(3000);
                    setInterval(() => {
                        $('#message-delete').hide();
                    }, 2000);
                },
                error: function(data){
                    console.log(data);
                }
            })
        });
    </script>
@endsection
