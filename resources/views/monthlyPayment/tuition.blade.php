@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h3 class="my-4 text-secondary text-center">Mensalidades</h3>
        </div>
        <div id="message-return"></div>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form class="col-12" autocomplete="off" id="form-filter">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="contractor">Contrante</label>
                        <input type="text" name="contractor" id="contractor" class="form-control">
                    </div>
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
                            @foreach ( $pavements as $pavement)
                                <option value="{{$pavement->id}}">{{$pavement->name}}</option>
                            @endforeach
                        </select>
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
                        <td>Pavimentos</td>
                        <td>Lojas</td>
                        <td>Data de vencimento</td>
                        <td>Contrante</td>
                        <td>Valor a pagar</td>
                        <td>Valor Pago</td>
                        <td>Saldo</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody id="body-table">

                </tbody>
            </table>
        </div>
        {{-- <div class="d-flex justify-content-center my-2">
            {{ $tuition->appends(request()->input())->links()}}
        </div> --}}
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
                                <option value="{{$typePayment->value}}">{{$typePayment->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="amount_paid">Valor Recebido</label>
                        <input type="text" name="amount_paid" id="amount_paid" class="form-control" data-mask="000.000.000.000.000,00" data-mask-reverse="true" required>
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
                        <input type="date" name="dt_cancellation" id="dt_cancellation" class="form-control" required>
                    </div>
                    <div>
                        <label for="id_cancellation">Motivo do Cancelamento</label>
                        <select name="id_cancellation" id="id_cancellation" class="form-control" required>
                            <option value="" disabled selected>Selecione uma opção</option>
                            @foreach ($typesCancellations as $typeCancellation)
                                <option value="{{$typeCancellation->value}}">{{$typeCancellation->description}}</option>
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
        $(document).delegate('#btn-low','click',function(){
            var id_monthly = $(this).attr('data-id-monthly');
            $('#id_monthly').val(id_monthly);
        });

        $(document).delegate('#btn-cancel', 'click', function(){
            var id_monthly = $(this).attr('data-id-monthly');
            $('#id_monthly_cancel').val(id_monthly);
        });

        $(document).delegate('#btn-low','click',function(){
            var balance_value = $(this).attr('data-balance-value');
            $('#amount_paid').val(balance_value);
        });


        $('#form-filter').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('monthly.tuitionAjax')}}",
                type: 'get',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    var itemTable = $('#body-table');
                    itemTable.empty();
                    $.each(response, function(index, item){

                        const dateString = item.due_date;
                        const [year, month, day] = dateString.split('-');
                        const due_date = `${day}/${month}/${year}`;

                        var urlReceipt = "{{route('pdfReports.receipt', ['id_receipt' => ':id_receipt'])}}";
                        urlReceipt = urlReceipt.replace(':id_receipt', item.id);

                        var urlPartialReceipt = "{{route('pdfReports.partialReceipt', ['id_receipt' => ':idPartialReceipt'])}}";
                        urlPartialReceipt = urlPartialReceipt.replace(':idPartialReceipt', item.id);

                        var b_value = item.balance_value;
                        var balance_value = b_value.toLocaleString('pt-br', {minimumFractionDigits: 2});

                        var tr = '<tr>';

                        if(item.id_monthly_status === 'F'){
                            tr = '<tr class="bg-success">';
                            options = '<a href="'+urlReceipt+'" class="btn btn-sm btn-primary" target="_blank">Recibo</a>';
                        }else if(item.id_monthly_status === 'P'){
                            tr = '<tr class="bg-secondary">';
                            options = '<div class="d-flex">'+
                                        '<a href="" class="mr-3 btn btn-sm btn-success" id="btn-low" data-id-monthly="'+item.id+'" data-bs-toggle="modal" data-balance-value="'+balance_value+'" data-bs-target="#modal-low">Baixar</a>'+
                                        '<a href="'+urlPartialReceipt+'" class="btn btn-sm btn-primary" target="_blank">Recibo</a>'+
                                      '</div>';
                        }else if(item.id_monthly_status === 'C'){
                            tr = '<tr class="bg-danger text-white">';
                            options = '<div><h6>-</h6></div>';
                        }else{
                            tr = '<tr>';
                            options = '<a href="" class="mr-3 btn btn-sm btn-outline-success" id="btn-low" data-id-monthly="'+item.id+'" data-bs-toggle="modal" data-balance-value="'+balance_value+'" data-bs-target="#modal-low">Baixar</a>'+
                                      '<a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-cancel" data-id-monthly="'+item.id+'" data-bs-toggle="modal" data-bs-target="#modal-cancel">Cancelar</a>';
                        }

                        itemTable.append(
                                    tr+
                                    '<td>'+item.pavements+'</td>'+
                                    '<td>'+item.stores+'</td>'+
                                    '<td>'+due_date+'</td>'+
                                    '<td>'+item.name_contractor+'</td>'+
                                    "<td>R$"+item.total_payable+"</td>"+
                                    "<td>R$"+item.amount_paid+"</td>"+
                                    "<td>R$"+item.balance_value+"</td>"+
                                    '<td>'+options+'</td>'+
                                '</tr>'
                        )
                    });
                }
            });
        });

        $(document).ready(function(){
            $.ajax({
                url: "{{route('monthly.tuitionAjax')}}",
                type: 'get',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    var itemTable = $('#body-table');
                    itemTable.empty();
                    $.each(response, function(index, item){

                        const dateString = item.due_date;
                        const [year, month, day] = dateString.split('-');
                        const due_date = `${day}/${month}/${year}`;

                        var urlReceipt = "{{route('pdfReports.receipt', ['id_receipt' => ':id_receipt'])}}";
                        urlReceipt = urlReceipt.replace(':id_receipt', item.id);

                        var urlPartialReceipt = "{{route('pdfReports.partialReceipt', ['id_receipt' => ':idPartialReceipt'])}}";
                        urlPartialReceipt = urlPartialReceipt.replace(':idPartialReceipt', item.id);

                        var b_value = item.balance_value;
                        var balance_value = b_value.toLocaleString('pt-br', {minimumFractionDigits: 2});

                        var tr = '<tr>';

                        if(item.id_monthly_status === 'F'){
                            tr = '<tr class="bg-success">';
                            options = '<a href="'+urlReceipt+'" class="btn btn-sm btn-primary" target="_blank">Recibo</a>';
                        }else if(item.id_monthly_status === 'P'){
                            tr = '<tr class="bg-secondary">';
                            options = '<div class="d-flex">'+
                                        '<a href="" class="mr-3 btn btn-sm btn-success" id="btn-low" data-id-monthly="'+item.id+'" data-bs-toggle="modal" data-balance-value="'+balance_value+'" data-bs-target="#modal-low">Baixar</a>'+
                                        '<a href="'+urlPartialReceipt+'" class="btn btn-sm btn-primary" target="_blank">Recibo</a>'+
                                      '</div>';
                        }else if(item.id_monthly_status === 'C'){
                            tr = '<tr class="bg-danger text-white">';
                            options = '<div><h6>-</h6></div>';
                        }else{
                            tr = '<tr>';
                            options = '<a href="" class="mr-3 btn btn-sm btn-outline-success" id="btn-low" data-id-monthly="'+item.id+'" data-bs-toggle="modal" data-balance-value="'+balance_value+'" data-bs-target="#modal-low">Baixar</a>'+
                                      '<a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-cancel" data-id-monthly="'+item.id+'" data-bs-toggle="modal" data-bs-target="#modal-cancel">Cancelar</a>';
                        }
                        itemTable.append(
                                    tr+
                                    '<td>'+item.pavements+'</td>'+
                                    '<td>'+item.stores+'</td>'+
                                    '<td>'+due_date+'</td>'+
                                    '<td>'+item.name_contractor+'</td>'+
                                    "<td>R$"+item.total_payable+"</td>"+
                                    "<td>R$"+item.amount_paid+"</td>"+
                                    "<td>R$"+item.balance_value+"</td>"+
                                    '<td>'+options+'</td>'+
                                '</tr>'
                        )
                    });
                }
            });
        });

        $('#cancelTuition').submit(function(event){
            event.preventDefault();
            $.ajax({
                url:"{{route('monthly.cancelTuition')}}",
                type:'post',
                data: $(this).serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
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

        $('#lowerMonthlyFee').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('monthly.lowerMonthlyFee')}}",
                type: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    if(response.alert){
                        $('#message-return').html(response.alert);
                        $('#modal-low').modal('hide');
                        $('#message-return').addClass('alert alert-warning').show();
                        $('#message-return').fadeOut(5000);
                        setInterval(() => {
                            $('#message-return').hide();
                        },5000);
                    }else{
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
    </script>
@endsection
