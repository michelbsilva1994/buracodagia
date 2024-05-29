@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Contratos</h1>
        </div>
        <div id="message-delete"></div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4">
            <a href="{{route('contract.create')}}" class="btn btn-success btn-lg"> + Novo Contrato</a>
        </div>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form action="{{route('contract.index')}}" method="get" class="col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="name_contractor">Contratante</label>
                        <input type="text" name="name_contractor" id="name_contractor" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" data-mask="000.000.000-00">
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
                        <td>Tipo de Pessoa</td>
                        <td>Tipo de Contrato</td>
                        <td>Contratante</td>
                        <td>CPF/CNPJ</td>
                        <td>Valor do Contrato</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contracts as $contract)
                    <tr id="contract-{{$contract->id}}">
                            <td>{{$contract->id}}</td>
                            <td>{{$contract->type_person}}</td>
                            <td>{{$contract->type_contract}}</td>
                            <td>{{$contract->name_contractor}}</td>
                            <td>{{$contract->cpf ?? $contract->cnpj}}</td>
                            <td>R$ {{number_format($contract->total_price, 2, ',', '.')}}</td>
                            <td class="d-flex">
                                <a class="mr-3 btn btn-sm btn-outline-success" href="{{route('contract.edit', ['contract' => $contract->id])}}">Editar</a>
                                <a class="mr-3 btn btn-sm btn-outline-secondary" href="{{route('contract.show', ['contract' => $contract->id])}}">Detalhe</a>
                                <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-delete" data-id-contract="{{$contract->id}}" data-bs-toggle="modal" data-bs-target="#modal-delete">Excluir</a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center my-2">
            {{ $contracts->appends(request()->input())->links()}}
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
              Tem certeza que deseja excluir o contrato?
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_contract" id="id_contract">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-destroy">Excluir</button>
            </div>
          </div>
        </div>
    </div>
    <script>
        $(document).delegate('#btn-delete','click', function(){
            var id_contract = $(this).attr('data-id-contract');
            $('#id_contract').val(id_contract);
        });
        $(document).delegate('#btn-destroy', 'click', function(){
            var id_contract = $('#id_contract').val();

            $.ajax({
                url: '/public/contract/'+id_contract,
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
                        $('#message-delete').fadeOut(4000);
                        setTimeout(function() {
                        $('#message-delete').hide();
                        }, 4000);
                    }
                    if(response.sign){
                        $('#message-delete').html(response.sign);
                        $('#message-delete').removeClass('alert alert-success');
                        $('#modal-delete').modal('hide');
                        $('#message-delete').addClass('alert alert-warning').show();
                        $('#message-delete').fadeOut(4000);
                        setTimeout(function() {
                        $('#message-delete').hide();
                        }, 4000);
                    }
                    if(response.status){
                        console.log(response.status);
                        $('#message-delete').html(response.status);
                        $('#message-delete').removeClass('alert alert-warning');
                        $('#modal-delete').modal('hide');
                        $('#message-delete').addClass('alert alert-success').show();
                        $('#contract-'+id_contract).remove();
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
