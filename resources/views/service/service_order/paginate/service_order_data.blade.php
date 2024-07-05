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
                    @elseif ($serviceOrder->id_status == 'F' && !empty($serviceOrder->dt_service))
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
                            @elseif ($serviceOrder->id_status == 'F' && !empty($serviceOrder->dt_service))
                            @endif
                            <a class="mr-3 btn btn-sm btn-outline-primary" href="">Histórico</a>
                        @endif
                        @if (Auth::user()->user_type_service_order == 'U')
                            <a class="mr-3 btn btn-sm btn-outline-primary" href="">Histórico</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
