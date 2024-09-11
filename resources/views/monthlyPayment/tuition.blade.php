@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            @if (Auth::user()->user_type_service_order == 'U')
                <h3 class="my-4 text-secondary text-center">Minhas Mensalidades</h3>
            @else
                <h3 class="my-4 text-secondary text-center">Mensalidades</h3>
            @endif
        </div>
        <div id="message-return"></div>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form class="col-12" autocomplete="off" id="form-filter">
                <div class="row">
                    @if (empty(Auth::user()->user_type_service_order) or Auth::user()->user_type_service_order == 'E')
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <label for="contractor">Contratante</label>
                            <input type="text" name="contractor" id="contractor" class="form-control">
                        </div>
                    @endif
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date">Data Vencimento</label>
                        <input type="date" name="due_date" id="due_date" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="store">Loja</label>
                        <input type="text" name="store" id="store" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="pavement">Pavimento</label>
                        <select name="pavement" id="pavement" class="form-control">
                            <option value="">Selecione uma opção</option>
                            @foreach ($pavements as $pavement)
                                <option value="{{ $pavement->id }}">{{ $pavement->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                        <button type="submit" class="btn btn-lg btn-success">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-data">
            <div id="items-container">
                @include('monthlyPayment.tuition_data')
            </div>

            <div id="pagination-container">
                @include('monthlyPayment.pagination')
            </div>
        </div>
    </div>

    <!-- modal baixar mensalidade -->
    <div class="modal fade" id="modal-low" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Baixar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="lowerMonthlyFee">
                        <div>
                            <input type="hidden" name="id_monthly" id="id_monthly">
                        </div>
                        <div>
                            <label for="dt_payday">Data da baixa</label>
                            <input type="date" name="dt_payday" id="dt_payday" class="form-control" required>
                        </div>
                        <div>
                            <label for="id_payment">Forma de pagamento</label>
                            <select name="id_payment" id="id_payment" class="form-control" required>
                                @foreach ($typesPayments as $typePayment)
                                    <option value="{{ $typePayment->value }}">{{ $typePayment->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="amount_paid">Valor Recebido</label>
                            <input type="text" name="amount_paid" id="amount_paid" class="form-control"
                                data-mask="000.000.000.000.000,00" data-mask-reverse="true" required>
                        </div>
                        <div class="d-grid gap-2 my-3">
                            <button type="submit" class="btn btn-success" id="btn-low-monthly">Baixar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                id="teste">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal cancelar mensalidade -->
    <div class="modal fade" id="modal-cancel" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Tem certeza que deseja cancelar a mensalidade?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cancelTuition">
                        <div>
                            <input type="hidden" name="id_monthly_cancel" id="id_monthly_cancel">
                        </div>
                        <div>
                            <label for="dt_cancellation">Data da Cancelamento</label>
                            <input type="date" name="dt_cancellation" id="dt_cancellation" class="form-control"
                                required>
                        </div>
                        <div>
                            <label for="id_cancellation">Motivo do Cancelamento</label>
                            <select name="id_cancellation" id="id_cancellation" class="form-control" required>
                                <option value="" disabled selected>Selecione uma opção</option>
                                @foreach ($typesCancellations as $typeCancellation)
                                    <option value="{{ $typeCancellation->value }}">{{ $typeCancellation->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-grid gap-2 my-3">
                            <button type="submit" class="btn btn-success" id="btn-cancel-monthly">Cancelar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
            <!-- modal baixar mensalidade -->
            <div class="modal fade" id="modal-reverse-low" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalToggleLabel">Estornar baixa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="reverseLowerMonthlyFee">
                                <div>
                                    <input type="hidden" name="id_lowerMonthlyFee" id="id_lowerMonthlyFee">
                                </div>
                                <div class="d-grid gap-2 my-3">
                                    <button type="submit" class="btn btn-danger" id="btn-reverse-low-monthly">Estornar</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                        id="teste">Fechar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <!-- modal baixas -->
        {{-- <div class="modal fade" id="modal-lowers" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Baixas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="content">

                    </div>
                </div>
            </div>
        </div> --}}

    <script>
        // $(document).on('submit', '#form-filter', function(event){
        //     event.preventDefault();
        //     fetchItems("{{ route('monthly.tuitionAjax') }}?" + $(this).serialize());
        // });
        // $(document).delegate('#btn-lowers', 'click', function() {
        //     event.preventDefault();
        //     $('#content').html('teste de html');
        // });
        $(document).ready(function() {
            $('#form-filter').on('submit', function(event) {
                event.preventDefault();
                var url = "{{ route('monthly.tuitionAjax') }}?" + $(this).serialize();
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
        $(document).delegate('#btn-low', 'click', function() {
            var id_monthly = $(this).attr('data-id-monthly');
            $('#id_monthly').val(id_monthly);
        });

        $(document).delegate('#btn-cancel', 'click', function() {
            var id_monthly = $(this).attr('data-id-monthly');
            $('#id_monthly_cancel').val(id_monthly);
            console.log(id_monthly);
        });

        $(document).delegate('#btn-low', 'click', function() {
            var balance_value = $(this).attr('data-balance-value');
            $('#amount_paid').val(balance_value);
        });
        $(document).delegate('#btn-reverse', 'click', function(){
            var id_lowerMonthlyFee = $(this).attr('data-id-lowerMonthlyFee');
            $('#id_lowerMonthlyFee').val(id_lowerMonthlyFee);
        })

        $(document).delegate('.accordion', 'click', function() {
            var id_monthly_lower = $(this).attr('data-id-lower');
            var url = "{{route('monthly.lowerMonthlyFeeIndex', ['id_monthly' => ':id'])}}"
            url = url.replace(':id', id_monthly_lower)
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(response){
                    console.log(response.lowers)
                    $('#body-table'+id_monthly_lower).empty();

                    var type_user = '{{Auth::user()->user_type_service_order}}';
                    var dataList = $('#body-table'+id_monthly_lower);

                    var formatter = new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    });

                    if(response.lowers.length == 0){
                            dataList.append('<tr>'+
                                '<td> Sem Baixas realizadas!</td>'
                            +'<tr>')
                    }
                    if(response.lowers.length > 0){
                    response.lowers.forEach(function(item){
                        if(item.id_lower_monthly_fees_reverse == null && item.operation_type == 'B'){
                            var tr = '<tr class="bg-success text-white">';
                        }
                        else if (item.operation_type == 'B'){
                            var tr = '<tr class="bg-secondary text-white">';
                        }
                        else if(item.operation_type == 'E'){
                            var tr = '<tr class="bg-danger text-white">';
                        }

                        if(item.id_lower_monthly_fees_reverse == null){
                                var id_lower_monthly_fees_reverse =  '<td> - </td>';
                        }else{
                            var id_lower_monthly_fees_reverse = '<td>' +  item.id_lower_monthly_fees_reverse +'</td>';
                        }
                        if(item.dt_payday){
                            var dt_baixa = '<td>'+ (item.dt_payday) + '</td>';
                        }
                        if(item.dt_chargeback){
                            var dt_baixa = '<td>'+ (item.dt_chargeback) + '</td>';
                        }

                        if(item.operation_type == 'B'){
                            var download_user = '<td>'+ item.download_user + '</td>';
                            var type_payment = '<td>'+ item.type_payment + '</td>';
                        }
                        if(item.operation_type == 'E'){
                            var download_user = '<td>'+ item.chargeback_user + '</td>';
                            var type_payment = '<td> Estorno </td>';
                        }

                        if(item.id_lower_monthly_fees_reverse != null)
                               var lower =  '<td> - </td>'
                        if(item.id_lower_monthly_fees_reverse == null){
                            if(item.operation_type == 'B'){
                                if( type_user == 'E'){
                                    var lower = '<td><a href="" class="mr-3 btn btn-sm btn-danger" id="btn-reverse" data-id-lowerMonthlyFee="'+ item.id +'" data-bs-toggle="modal" data-bs-target="#modal-reverse-low">Estornar</a></td>'
                                }
                                else{
                                    var lower = '<td> - </td>'
                                }
                            }
                            else if(item.operation_type == 'E'){
                                var lower = '<td> - </td>'
                            }
                        }
                            dataList.append(tr+
                            '<td>' + item.id +'</td>'+
                            id_lower_monthly_fees_reverse+
                            type_payment+
                            '<td>'+ formatter.format(item.amount_paid) + '</td>'+
                            dt_baixa.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1')+
                            download_user+
                            lower
                            +'<tr>');

                    });
                }
                }
            });
            // $('#accordion-body-'+id_monthly_lower).html('<p>'+ id_monthly_lower +'</p>')
        });

        $('#cancelTuition').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('monthly.cancelTuition') }}",
                type: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#message-return').html(response.status);
                    $('#modal-cancel').modal('hide');
                    $('#message-return').addClass('alert alert-success').show();
                    $('#message-return').fadeOut(3000);
                    setInterval(() => {
                        $('#message-return').hide();
                    }, 2000);
                },
            });

        });

        $('#lowerMonthlyFee').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('monthly.lowerMonthlyFee') }}",
                type: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.alert) {
                        $('#message-return').html(response.alert);
                        $('#modal-low').modal('hide');
                        $('#message-return').addClass('alert alert-warning').show();
                        $('#message-return').fadeOut(5000);
                        setInterval(() => {
                            $('#message-return').hide();
                        }, 5000);
                    } else {
                        $('#message-return').html(response.status);
                        $('#modal-low').modal('hide');
                        $('#message-return').addClass('alert alert-success').show();
                        $('#message-return').fadeOut(5000);
                        setInterval(() => {
                            $('#message.return').hide();
                        }, 5000);
                    }
                }
            });
        });

        $('#reverseLowerMonthlyFee').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{route('monthly.reverseMonthlyPayment')}}",
                type: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.alert) {
                        $('#message-return').html(response.alert);
                        $('#modal-reverse-low').modal('hide');
                        $('#message-return').addClass('alert alert-warning').show();
                        $('#message-return').fadeOut(5000);
                        setInterval(() => {
                            $('#message-return').hide();
                        }, 5000);
                    } else {
                        $('#message-return').html(response.status);
                        $('#modal-reverse-low').modal('hide');
                        $('#message-return').addClass('alert alert-success').show();
                        $('#message-return').fadeOut(5000);
                        setInterval(() => {
                            $('#message.return').hide();
                        }, 5000);
                    }
                }
            });
        });

        $('#modal-low').on('hidden.bs.modal', function(event) {
            event.preventDefault();
            var url = window.location.href;
            fetchItems(url);
            window.history.pushState("", "", url);
        });

        $('#modal-reverse-low').on('hidden.bs.modal', function(event) {
            event.preventDefault();
            var url = window.location.href;
            fetchItems(url);
            window.history.pushState("", "", url);
        });

        $('#modal-cancel').on('hidden.bs.modal', function(event) {
            event.preventDefault();
            var url = window.location.href;
            fetchItems(url);
            window.history.pushState("", "", url);
        });
    </script>
@endsection
