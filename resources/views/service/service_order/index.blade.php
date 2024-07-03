@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Ordem de Serviço</h1>
        </div>
        <div id="message-return"></div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4">
            <a href="{{ route('serviceOrders.create') }}" class="btn btn-success btn-lg"> + Criar Ordem de Serviço</a>
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
                    @foreach ($serviceOrders as $serviceOrder)
                        <tr>
                            <td>{{ $serviceOrder->id }}</td>
                            <td>{{ $serviceOrder->title }}</td>
                            <td>{{ Date('d/m/Y', strtotime($serviceOrder->dt_opening)) }}</td>
                            @if ($serviceOrder->id_status == 'A')
                                <td>Aberta</td>
                            @elseif ($serviceOrder->id_status == 'P')
                                <td>Em processo</td>
                            @elseif ($serviceOrder->id_status == 'F')
                                <td>Fechada</td>
                            @endif
                            <td class="d-flex">
                                @if (Auth::user()->user_type_service_order == 'E')
                                    @if ($serviceOrder->id_status == 'A' && empty($serviceOrder->dt_proccess) && empty($serviceOrder->dt_serivce))
                                        <a href="" class="mr-3 btn btn-sm btn-outline-success" id="btn-start"
                                            data-id-service-order="{{ $serviceOrder->id }}" data-bs-toggle="modal"
                                            data-bs-target="#modal-start">Iniciar</a>
                                    @elseif ($serviceOrder->id_status == 'P' && !empty($serviceOrder->dt_process) && empty($serviceOrder->dt_serivce))
                                        <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-close"
                                            data-id-service-order="{{ $serviceOrder->id }}" data-bs-toggle="modal"
                                            data-bs-target="#modal-close">Encerrar</a>
                                    @elseif ($serviceOrder->id_status == 'F' && isset($serviceOrder->dt_serivce))
                                    @endif
                                    <a class="mr-3 btn btn-sm btn-outline-primary" href="">Histórico</a>
                                @endif
                                @if (Auth::user()->user_type_service_order == 'C')
                                    <a class="mr-3 btn btn-sm btn-outline-primary" href="">Histórico</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-start" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Iniciar atendimento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja iniciar o atendimento da Ordem de Serviço?
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_service_order" id="id_service_order">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btn-start-service_order">Iniciar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).delegate('#btn-start', 'click', function() {
            var id_service_order = $(this).attr('data-id-service-order');
            $('#id_service_order').val(id_service_order);
            //alert(id_service_order);
        });

        $(document).delegate('#btn-start-service_order', 'click', function() {
            var id_service_order = $('#id_service_order').val();
            alert(id_service_order);
            var url = "{{ route('serviceOrders.startWorkOrder') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                        console.log(response.status);
                        $('#message-return').html(response.status);
                        $('#modal-start').modal('hide');
                        $('#message-return').addClass('alert alert-success').show();
                        $('#message-return').fadeOut(3000);
                        setTimeout(function() {
                            $('#message-return').hide();
                        }, 2000);
                },
                error: function(data) {
                    console.log(data);
                }
            })
        });
    </script>
@endsection
