@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="text-secondary mt-2">Contrato Nº {{$contract->id}}</h1>
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
        <div class="d-flex">
                <a href="{{route('contract.index')}}" class="btn btn-danger mr-2">Voltar</a>
                @if(empty($contract->dt_signature))
                    <form action="{{ route('contract.singContract', ['contract'=>$contract->id]) }}" method="post" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input class="btn btn-success" type="submit" value="Assinar Contrato">
                    </form>
                @endif
                @if(!empty($contract->dt_signature) && strtotime($contract->dt_renovation) < strtotime(date('Y/m/d')))
                    <a class="btn btn-primary" href="">Renovar</a>
                @endif
        </div>
        <div class="mt-5">
            <h3 class="text-secondary">Tipo de Pessoa: {{$contract->type_person}}</h3>
            <h3 class="text-secondary">Tipo de Contrato: {{$contract->type_contract}}</h3>
            <h3 class="text-secondary">Contratante: {{$contract->name_contractor}}</h3>
            <h3 class="text-secondary">CPF/CNPJ: {{$contract->cpf ?? $contract->cnpj}}</h3>
            <h3 class="text-secondary">Data do Contrato: {{$contract->dt_contraction}}</h3>
            <h3 class="text-secondary">Data do Renovação: {{$contract->dt_renovation}}</h3>
        </div>
        <div>
            <hr>
            <h2 class="text-secondary text-center">Lojas</h2>
            <div id="message-store-delete"></div>
            <div class="col-12 table-responsive">
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
                                <td>{{$store->id_store}}</td>
                                <td>R$ {{$store->store_price}}</td>
                                @if(empty($contract->dt_signature))
                                    <td class="d-flex">
                                        <a class="mr-3 btn btn-sm btn-outline-success" href="">Editar</a>
                                        <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-store-delete" data-id-store-contract="{{$store->id}}" data-bs-toggle="modal" data-bs-target="#modal-store-delete">Excluir</a>
                                        <form action="{{route('contract.removeStore',['contractRemoveStore'=>$store->id])}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <input class="mr-3 btn btn-sm btn-outline-danger" type="submit" value="Remover" >
                                        </form>
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
                    <div class="col-6">
                        <label for="id_store" class="text-secondary">Loja</label>
                        <select name="id_store" id="id_store" class="form-select">
                            <option selected disabled>Selecione uma opção</option>
                            @foreach ($stores as $store)
                                <option value="{{$store->id}}">{{$store->name}}</option>
                            @endforeach
                        </select>
                        @error('id_store')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-6">
                        <label for="store_price" class="text-secondary">Valor</label>
                        <input type="number" class="form-control @error('store_price') is-invalid @enderror" id="store_price"
                            placeholder="Insira o valor da loja" name="store_price" value="{{ old('store_price') }}">
                        @error('store_price')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-block btn-success">Salvar</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>

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
                url: id_store_contract+"/removeStore",
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
