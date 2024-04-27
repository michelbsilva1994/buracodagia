@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h2 class="my-4 text-secondary text-center">Contrato Nº {{$contract->id}}</h2>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="{{route('contract.index')}}" class="btn btn-lg btn-danger">Voltar</a>
                @if(empty($contract->dt_signature))
                    <form action="{{ route('contract.singContract', ['contract'=>$contract->id]) }}" method="post" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <input class="btn btn-lg btn-success" type="submit" value="Assinar Contrato">
                        </div>
                    </form>
                @endif
        </div>
        <div class="mt-5">
            <h3 class="text-secondary">Tipo de Pessoa: {{$contract->type_person}}</h3>
            <h3 class="text-secondary">Tipo de Contrato: {{$contract->type_contract}}</h3>
            <h3 class="text-secondary">Contratante: {{$contract->name_contractor}}</h3>
            <h3 class="text-secondary">CPF/CNPJ: {{$contract->cpf ?? $contract->cnpj}}</h3>
            <h3 class="text-secondary">Data do Contrato: {{date('d/m/Y', strtotime($contract->dt_contraction))}}</h3>
            <h3 class="text-secondary">Valor do Contrato: R$ {{number_format($contract->total_price, 2, ',', '.')}}</h3>
        </div>
        <div>
            <hr>
            <h2 class="my-2 text-secondary text-center">Lojas</h2>
            <div id="message-store-delete"></div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Loja</td>
                            <td>Valor</td>
                            @if(empty($contract->dt_signature))
                                <td>Ações</td>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contractStore as $store)
                        <tr id="store-contract-{{$store->id}}">
                                <td>{{$store->id}}</td>
                                <td>{{$store->name}} - {{$store->pavement->name}}</td>
                                <td>R$ {{number_format($store->store_price, 2, ',', '.')}}</td>
                                @if(empty($contract->dt_signature))
                                    <td class="d-flex">
                                        <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-store-delete" data-id-store-contract="{{$store->id}}" data-bs-toggle="modal" data-bs-target="#modal-store-delete">Excluir</a>
                                    </td>
                                @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(empty($contract->dt_signature))
            <div>
                <form action="{{route('contract.contractStore', ['contract' => $contract->id])}}" method="post" class="mt-4 row" autocomplete="off">
                    @csrf
                    <div class="col-sm-12 col-md-6">
                        <label for="id_store" class="text-secondary">Loja</label>
                        <select name="id_store" id="id_store" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($stores as $store)
                                <option value="{{$store->id}}">{{$store->name}} - {{$store->pavement->name}}</option>
                            @endforeach
                        </select>
                        @error('id_store')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="store_price" class="text-secondary">Valor</label>
                        <input type="number" step="0.01" class="form-control @error('store_price') is-invalid @enderror" id="store_price"
                            placeholder="Insira o valor da loja" name="store_price" value="{{ old('store_price') }}">
                        @error('store_price')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end my-3">
                        <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end my-3">
            @if(!empty($contract->dt_signature) && empty($contract->dt_cancellation))
                <a href="" class="btn btn-lg btn-danger" id="btn-cancel_contract" data-id-cancel-contract="{{$contract->id}}" data-bs-toggle="modal" data-bs-target="#modal-cancel-contract">Cancelar Contrato</a>
            @endif
            @can('reverse_contract_signature')
                @if(($contract->dt_signature) && empty($contract->dt_cancellation))
                    <a href="" class="btn btn-lg btn-primary" id="btn-cancel_contract" data-id-cancel-contract="{{$contract->id}}" data-bs-toggle="modal" data-bs-target="#modal-reverse-contract-signature">Estornar Assinatura</a>
                @endif
            @endcan
        </div>
    </div>

    {{-- Modal cancelar contrato --}}
    <div class="modal fade" id="modal-cancel-contract" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel">Cancelar Contrato</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Tem certeza que deseja cancelar o contrato?
              <form action="{{route('contract.cancelContract', ['contract' => $contract->id])}}" method="post">
                @csrf
                <label for="id_cancellation">Motivo do Cancelamento do Contrato</label>
                <select name="id_cancellation" id="id_cancellation" class="form-control" required>
                    <option value="" disabled selected>Selecione uma opção</option>
                    @foreach ($contractCancellationType as $typeCancellationContract)
                        <option value="{{$typeCancellationContract->value}}">{{$typeCancellationContract->description}}</option>
                    @endforeach
                </select>
                <div class="d-grid gap-2 my-3">
                    <button type="submit" class="btn btn-success" id="btn-cancel-monthly">Cancelar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="modal-reverse-contract-signature" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel">Estornar Assinatura do Contrato</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Tem certeza que deseja estonar a assinatura do contrato?
              <form action="{{route('contract.reverseContractSignature', ['contract' => $contract->id])}}" method="post">
                @csrf
                @method('PUT')
                <div class="d-grid gap-2 my-3">
                    <button type="submit" class="btn btn-success" id="btn-cancel-monthly">Estornar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>

    {{-- Modal excluir Loja --}}
    <div class="modal fade" id="modal-store-delete" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel">Excluir loja</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Tem certeza que deseja excluir a loja do contrato?
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_store_contract" id="id_store_contract">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-store-destroy">Excluir</button>
            </div>
          </div>
        </div>
    </div>

    <script>
        $(document).delegate('#btn-store-delete', 'click', function(){
            var id_store_contract = $(this).attr('data-id-store-contract');
            $('#id_store_contract').val(id_store_contract);
        });

        $(document).delegate('#btn-store-destroy', 'click', function(){
            var id_store_contract = $('#id_store_contract').val();

            $.ajax({
                url: '/public/contract/'+id_store_contract+'/removeStore',
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    $('#message-store-delete').html(response.status);
                    $('#modal-store-delete').modal('hide');
                    $('#message-store-delete').addClass('alert alert-success').show();
                    $('#store-contract-'+id_store_contract).remove();
                    $('#message-store-delete').fadeOut(3000);
                    setTimeout(() => {
                        $('#message-store-delete').hide();
                    }, 2000);
                },
                error: function(data){
                    console.log(data);
                }
            })
        });
    </script>
@endsection
