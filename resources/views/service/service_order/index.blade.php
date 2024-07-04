@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h1 class="my-4 text-secondary text-center">Ordem de Serviço</h1>
        </div>
        <div id="message-return"></div>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form class="col-12" id="form-filter">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="dt_opening_initial">Data Vencimento Inicial</label>
                        <input type="date" name="dt_opening_initial" id="dt_opening_initial" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="dt_opening_final">Data Vencimento Inicial</label>
                        <input type="date" name="dt_opening_final" id="dt_opening_final" class="form-control">
                    </div>
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                        <button type="submit" class="btn btn-lg btn-success" id="filter">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4">
            <a href="{{ route('serviceOrders.create') }}" class="btn btn-success btn-lg"> + Criar Ordem de Serviço</a>
        </div>
        <div class="table_data">
            <div id="items-container">
                @include('service.service_order.paginate.service_order_data')
            </div>
            <div id="pagination-container">
                @include('service.service_order.paginate.paginate')
            </div>
        </div>
    </div>

    {{-- modal iniciar ordem de serviço --}}
    <div class="modal fade" id="modal-start" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Tem certeza que deseja iniciar a ordem de serviço?
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="starServiceOrder">
                        <div>
                            <input type="hidden" name="id_service_order" id="id_service_order_start">
                        </div>
                        <div class="d-grid gap-2 my-3">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-success" id="btn-start-service-order">Iniciar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modal encerrar ordem de serviço --}}
    <div class="modal fade" id="modal-close" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Tem certeza que deseja iniciar a ordem de serviço?
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="closeServiceOrder">
                        <div>
                            <input type="hidden" name="id_service_order" id="id_service_order_close">
                        </div>
                        <div class="d-grid gap-2 my-3">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-success" id="btn-close-service-order">Encerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).delegate('#btn-start', 'click', function() {
            var id_service_order = $(this).attr('data-id-service-order');
            $('#id_service_order_start').val(id_service_order);
        });

        $(document).delegate('#btn-close', 'click', function(){
            var id_service_order = $(this).attr('data-id-service-order');
            $('#id_service_order_close').val(id_service_order);
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

        $('#closeServiceOrder').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('serviceOrders.closeWorkOrder')}}",
                type: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    $('#message-return').html(response.status);
                    $('#modal-close').modal('hide');
                    $('#message-return').addClass('alert alert-success').show();
                    $('#message-return').fadeOut(3000);
                    setInterval(() => {
                        $('#message-return').hide();
                    }, 2000);
                },
                error: function(data){
                    console.log(data);
                }
            });
        });

        $(document).ready(function() {
            $('#form-filter').on('submit', function(event) {
                event.preventDefault();
                var url = "{{ route('serviceOrders.serviceOrderindex') }}?" + $(this).serialize();
                fetchItems(url);
                window.history.pushState("", "", url);
            });
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            fetchItems(url);
            window.history.pushState("", "", url);
        });

        function fetchItems(url) {
            $.ajax({
                url: url,
                type: 'get',
                success: function(response) {
                    $('#items-container').html(response.html);
                    $('#pagination-container').html(response.pagination);
                },
                error: function(xhr) {
                    console.log('Error', xhr.statusText);
                }
            });
        }

        $('#modal-start').on('hidden.bs.modal', function(event) {
            event.preventDefault();
            var url = window.location.href;
            fetchItems(url);
            window.history.pushState("", "", url);
        });
        $('#modal-close').on('hidden.bs.modal', function(event) {
            event.preventDefault();
            var url = window.location.href;
            fetchItems(url);
            window.history.pushState("", "", url);
        });
    </script>
@endsection
