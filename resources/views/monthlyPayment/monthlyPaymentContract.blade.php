@extends('layout.app')
@section('content')
    <div class="container">
        <div class="my-4 text-secondary text-center">
            <h3>Mensalidades</h3>
            <h2>Contrato: {{ $contract->id }}</h2>
            <input type="hidden" id="id_contract" value="{{$contract->id}}">
        </div>
        <div id="message-return"></div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start my-3">
            <a href="{{ route('physical.contractPerson', ['id_person' => $contract->id_physical_person]) }}"
                class="btn btn-lg btn-danger mr-2">Voltar</a>
        </div>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form class="col-12" autocomplete="off" id="form-filter">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <label for="due_date">Data Vencimento</label>
                    <input type="date" name="due_date" id="due_date" class="form-control">
                </div>
                <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                    <button type="submit" class="btn btn-lg btn-success" id="filter">Filtrar</button>
                </div>
            </form>
        </div>
        <div class="table-data">
            <div id="items-container">
                @include('monthlyPayment.tuition_data')
            </div>

            <div id="pagination-container">
                @include('monthlyPayment.monthlyPaymentContract.pagination')
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
                            <input type="datetime-local" name="dt_payday" id="dt_payday" class="form-control" required>
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
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
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
                    <h5 class="modal-title" id="exampleModalToggleLabel">Tem certeza que deseja cancelar a mensalidade?
                    </h5>
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
                            <label for="id_cancellation">Forma de pagamento</label>
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

    <script>

        $(document).ready(function() {
            var id_contract = $('#id_contract').val();

            $('#form-filter').on('submit', function(event) {
                event.preventDefault();
                var urlAjax = "{{ route('monthly.MonthlyPaymentContract', ['contract' => ':id_contract'])}}?";
                urlAjax = urlAjax.replace(':id_contract', id_contract);
                url = urlAjax + $(this).serialize();
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
        });

        $(document).delegate('#btn-low', 'click', function() {
            var balance_value = $(this).attr('data-balance-value');
            $('#amount_paid').val(balance_value);
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

        $('#modal-low').on('hidden.bs.modal', function(event) {
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
