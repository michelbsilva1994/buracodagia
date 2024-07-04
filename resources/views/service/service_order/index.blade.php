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
                            @if ($serviceOrder->id_status == 'A' && empty($serviceOrder->dt_proccess) && empty($serviceOrder->dt_serivce))
                                <td>Aberta</td>
                            @elseif ($serviceOrder->id_status == 'P' && !empty($serviceOrder->dt_process) && empty($serviceOrder->dt_serivce))
                                <td>Em processo</td>
                            @elseif ($serviceOrder->id_status == 'F' && isset($serviceOrder->dt_serivce))
                                <td>Fechada</td>
                            @endif
                            <td class="d-flex">
                                @if (Auth::user()->user_type_service_order == 'E')
                                    @if ($serviceOrder->id_status == 'A' && empty($serviceOrder->dt_proccess) && empty($serviceOrder->dt_serivce))
                                        <a href="" class="mr-3 btn btn-sm btn-outline-success" id="btn-start" data-id-service-order="{{ $serviceOrder->id }}" data-bs-toggle="modal"
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
                    <h5 class="modal-title" id="exampleModalToggleLabel">Tem certeza que deseja iniciar a ordem de serviço?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="starServiceOrder">
                        <div>
                            <input type="hidden" name="id_service_order" id="id_service_order">
                        </div>
                        <div class="d-grid gap-2 my-3">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-success" id="btn-cancel-monthly">Iniciar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).delegate('#btn-start', 'click', function() {
            var id_service_order = $(this).attr('data-id-service-order');
            $('#id_service_order').val(id_service_order);
            alert(id_service_order);
        });

        $('#starServiceOrder').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('serviceOrders.startWorkOrder') }}",
                type: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    $('#message-return').html(response.status);
                    $('#modal-start').modal('hide');
                    $('#message-return').addClass('alert alert-success').show();
                    $('#message-return').fadeOut(3000);
                    setInterval(() => {
                        $('#message-return').hide();
                    }, 2000);
                },
            });

        });

        // $(document).delegate('#start-service-order', 'click', function(event) {
        //     event.preventDefault();
        //     var id_service_order =  $('#id_service_order').val();
        //     $.ajax({
        //         url: "{{ route('serviceOrders.startWorkOrder') }}",
        //         type: 'post',
        //         data: $(this).serialize(),
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //                 console.log(response.status);
        //                 $('#message-return').html(response.status);
        //                 $('#modal-start').modal('hide');
        //                 $('#message-return').addClass('alert alert-success').show();
        //                 $('#message-return').fadeOut(3000);
        //                 setTimeout(function() {
        //                     $('#message-return').hide();
        //                 }, 2000);
        //         },
        //         error: function(response) {
        //             console.log(response);
        //         }
        //     })
        // });
    </script>
@endsection
