@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Tipo de Contrato</h1>
        </div>
        <div id="message-delete"></div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start my-4">
            <a href="{{route('typeContract.create')}}" class="btn btn-lg btn-success"> + Novo</a>
        </div>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form class="col-sm-12 col-md-12 col-lg-12" id="form-filter">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="description">Nome</label>
                        <input type="text" name="description" id="description" class="form-control">
                    </div>
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                        <button type="submit" class="btn btn-lg btn-success">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="table_data">
            <div id="items-container">
                @include('domain.type_contract.pagination_data')
            </div>

            <div id="pagination-container">
                @include('domain.type_contract.pagination')
            </div>
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
              Tem certeza que deseja excluir o tipo de contrato?
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_type" id="id_type">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-destroy">Excluir</button>
            </div>
          </div>
        </div>
    </div>
    <script>

        $(document).on('submit', '#form-filter', function(event){
            event.preventDefault();
            fetchItems("{{route('typeContract.indexAjax')}}?" + $(this).serialize());
        });

        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var url = $(this).attr('href');
            fetchItems(url);
            window.history.pushState("","", url);
        })

        function fetchItems(url){
            $.ajax({
                url: url,
                type: 'get',
                success: function(response){
                    $('#items-container').html(response.html);
                    $('#pagination-container').html(response.pagination);
                },
                error: function(xhr){
                    console.log('Error', xhr.statusText);
                }
            });
        }

        $(document).delegate('#btn-delete','click', function(){
            var id_type = $(this).attr('data-id-type');
            $('#id_type').val(id_type);
        });

        $(document).delegate('#btn-destroy', 'click', function(){
            var id_type = $('#id_type').val();
            var url = "{{route('typeContract.destroy', ['typeContract'=>':id'])}}"
            url = url.replace(':id',id_type);
            $.ajax({
                url: url,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    $('#message-delete').html(response.status);
                    $('#modal-delete').modal('hide');
                    $('#message-delete').addClass('alert alert-success').show();
                    $('#type-contract-'+id_type).remove();
                    $('#message-delete').fadeOut(3000);
                    setTimeout(function() {
                        $('#message-delete').hide();
                    }, 2000);
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
    </script>
    {{-- <script>
            $(function(){
                $('form[name="form-filter"]').submit(function(event){
                    event.preventDefault();
                    $.ajax({
                    url: "{{route('typeContract.ajaxIndex')}}",
                    type: "get",
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response){
                        var itemTable = $('#body_table');
                        itemTable.empty();
                        $.each(response, function(index, item){
                            var url = "{{route('typeContract.edit', ['typeContract'=> ':id'])}}"
                            url = url.replace(':id',item.id);
                            itemTable.append('<tr id="type-contract-'+item.id+'">'+
                                            '<td>'+item.id+'</td>'+
                                            '<td>'+item.value+'</td>'+
                                            '<td>'+item.description+'</td>'+
                                            '<td>'+
                                            '<a class="mr-3 btn btn-sm btn-outline-success" href="'+url+'">Editar</a>'+
                                            '<a class="mr-3 btn btn-sm btn-outline-danger" id="btn-delete" data-id-type="'+item.id+'" data-bs-toggle="modal" data-bs-target="#modal-delete">Excluir</a>'+
                                            '</td>'+
                                            '</tr>')
                                        });
                        }
                    });
                });
            });
            $(function(){
                $.ajax({
                    url: "{{route('typeContract.ajaxIndex')}}",
                    type: "get",
                    dataType: 'json',
                    success: function(response){
                        var itemTable = $('#body_table');
                        itemTable.empty();
                        $.each(response, function(index, item){
                            var url = "{{route('typeContract.edit', ['typeContract'=> ':id'])}}"
                            url = url.replace(':id',item.id);
                            itemTable.append('<tr id="type-contract-'+item.id+'">'+
                                            '<td>'+item.id+'</td>'+
                                            '<td>'+item.value+'</td>'+
                                            '<td>'+item.description+'</td>'+
                                            '<td>'+
                                            '<a class="mr-3 btn btn-sm btn-outline-success" href="'+url+'">Editar</a>'+
                                            '<a class="mr-3 btn btn-sm btn-outline-danger" id="btn-delete" data-id-type="'+item.id+'" data-bs-toggle="modal" data-bs-target="#modal-delete">Excluir</a>'+
                                            '</td>'+
                                            '</tr>')
                                        });
                        }
                    });
            });
    </script> --}}
@endsection
