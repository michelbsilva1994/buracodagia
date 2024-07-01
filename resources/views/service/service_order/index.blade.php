@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Ordem de Serviço</h1>
        </div>
        <div id="message-delete"></div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4">
            <a href="{{route('serviceOrders.create')}}" class="btn btn-success btn-lg"> + Criar Ordem de Serviço</a>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>Nº Ordem Serviço</td>
                        <td>Título</td>
                        <td>Dt. Abertura</td>
                        <td>Status</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    {{-- <div class="modal fade" id="modal-delete" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel">Excluir Equipamento</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Tem certeza que deseja excluir o equipamento?
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_equipment" id="id_equipment">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-destroy">Excluir</button>
            </div>
          </div>
        </div>
    </div> --}}
      <script>
        $(document).delegate('#btn-delete', 'click', function(){
            var id_equipment = $(this).attr('data-id-equipment');
            $('#id_equipment').val(id_equipment);
        });

        $(document).delegate('#btn-destroy', 'click', function(){
            var id_equipment = $('#id_equipment').val();

            var url = "{{route('equipment.destroy', ['equipment' => ':equipment'])}}";
            url = url.replace(':equipment', id_equipment);

            $.ajax({
                url: url,
                type:'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    if(response.status){
                        $('#message-delete').html(response.status);
                        $('#modal-delete').modal('hide');
                        $('#message-delete').addClass('alert alert-success').show();
                        $('#equipment-'+id_equipment).remove();
                        $('#message-delete').fadeOut(3000);
                        setTimeout(function() {
                            $('#message-delete').hide();
                        }, 2000);
                    }
                    if(response.error){
                        $('#message-delete').html(response.error);
                        $('#modal-delete').modal('hide');
                        $('#message-delete').addClass('alert alert-danger').show();
                        $('#message-delete').fadeOut(3000);
                        setTimeout(function() {
                            $('#message-delete').hide();
                        }, 2000);
                    }
                },
                error: function(data){
                    console.log(data);
                }
            })
        });
      </script>
@endsection
