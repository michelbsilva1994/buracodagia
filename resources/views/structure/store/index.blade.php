@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Lojas</h1>
        </div>
        <div id="message-delete"></div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start my-4">
            <a href="{{route('store.create')}}" class="btn btn-success btn-lg"> + Criar Loja</a>
        </div>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form action="{{route('store.index')}}" method="get" class="col-sm-12 col-md-12 col-lg-12" autocomplete="off">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="cpf">Pavimento</label>
                        <select name="pavement" id="pavement" class="form-control">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($pavements as $pavement)
                                <option value="{{$pavement->id}}">{{$pavement->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                        <button type="submit" class="btn btn-lg btn-success">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Loja</td>
                        <td>Pavimento</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stores as $store)
                    <tr id="store-{{$store->id}}">
                            <td>{{$store->id}}</td>
                            <td>{{$store->name}}</td>
                            <td>{{$store->pavement->name}}</td>
                            <td class="d-flex">
                                <a class="mr-3 btn btn-sm btn-outline-success" href="{{route('store.edit', ['store'=>$store->id])}}">Editar</a>
                                <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-delete" data-id-store="{{$store->id}}" data-bs-toggle="modal" data-bs-target="#modal-delete">Excluir</a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center my-2">
            {{ $stores->appends(request()->input())->links()}}
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
              Tem certeza que deseja excluir a loja?
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_store" id="id_store">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-destroy">Excluir</button>
            </div>
          </div>
        </div>
    </div>
    <script>
        $(document).delegate('#btn-delete', 'click', function(){
            var id_store = $(this).attr('data-id-store');
            $('#id_store').val(id_store);
        });

        $(document).delegate('#btn-destroy','click', function(){
            var id_store = $('#id_store').val();

            $.ajax({
                url: '/public/store/'+id_store,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    if(response.linked){
                        $('#message-delete').html(response.linked);
                        $('#message-delete').removeClass('alert alert-success');
                        $('#modal-delete').modal('hide');
                        $('#message-delete').addClass('alert alert-warning').show();
                        $('#message-delete').fadeOut(5000);
                        setInterval(() => {
                            $('#message-delete').hide();
                        }, 5000);
                    }
                    if(response.status){
                        $('#message-delete').html(response.status);
                        $('#message-delete').removeClass('alert alert-warning');
                        $('#modal-delete').modal('hide');
                        $('#message-delete').addClass('alert alert-success').show();
                        $('#store-'+id_store).remove();
                        $('#message-delete').fadeOut(3000);
                        setInterval(() => {
                        $('#message-delete').hide();
                    }, 2000);
                    }
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
    </script>
@endsection
