@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Contratos</h1>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('alert'))
            <div class="alert alert-warning" role="alert">
                {{ session('alert') }}
            </div>
        @endif
        <div id="message-delete"></div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4">
            <a href="{{route('contract.create')}}" class="btn btn-success btn-lg"> + Novo Contrato</a>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Tipo de Pessoa</td>
                        <td>Tipo de Contrato</td>
                        <td>Contrante</td>
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
                url: "/contract/"+id_contract,
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
