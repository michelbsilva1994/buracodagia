@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Tipo de Loja</h1>
        </div>
        <div id="message-delete"></div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start my-4">
            <a href="{{route('storeType.create')}}" class="btn btn-lg btn-success"> + Novo</a>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>value</td>
                        <td>Descrição</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($storeType as $type)
                    <tr id="store-type-{{$type->id}}">
                            <td>{{$type->id}}</td>
                            <td>{{$type->value}}</td>
                            <td>{{$type->description}}</td>
                            <td class="d-flex">
                                <a class="mr-3 btn btn-sm btn-outline-success" href="{{route('storeType.edit', ['storeType'=>$type->id])}}">Editar</a>
                                <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-delete" data-id-store-type="{{$type->id}}" data-bs-toggle="modal" data-bs-target="#modal-delete">Excluir</a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-delete" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel">Modal 1</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Tem certeza que deseja excluir o status da loja?
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_store_type" id="id_store_type">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-destroy">Excluir</button>
            </div>
          </div>
        </div>
    </div>
    <script>
        $(document).delegate('#btn-delete','click', function(){
            var id_store_type = $(this).attr('data-id-store-type');
            $('#id_store_type').val(id_store_type);
        });
        $(document).delegate('#btn-destroy', 'click', function(){
            var id_store_type = $('#id_store_type').val();

            $.ajax({
                url: "/public/domain/storeType/"+id_store_type,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    $('#message-delete').html(response.status);
                    $('#modal-delete').modal('hide');
                    $('#message-delete').addClass('alert alert-success').show();
                    $('#store-type-'+id_store_type).remove();
                    $('#message-delete').fadeOut(3000);
                    setTimeout(function() {
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
