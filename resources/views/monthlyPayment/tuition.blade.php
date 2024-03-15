@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h3 class="my-4 text-secondary text-center">Mensalidades</h3>
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
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form action="{{route('monthly.filter')}}" class="col-12" method="get">
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
                        <td>Nº Mensalidade</td>
                        <td>Contrante</td>
                        <td>Lojas</td>
                        <td>Pavimentos</td>
                        <td>Data de vencimento</td>
                        <td>Valor a pagar</td>
                        <td>Valor Pago</td>
                        <td>Saldo</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tuition as $monthlyPayment)
                        @if ($monthlyPayment->id_monthly_status === 'F')
                        <tr class="bg-success text-white">
                            <td>{{$monthlyPayment->id}}</td>
                            <td>{{$monthlyPayment->name_contractor}}</td>
                            <td>{{date('d/m/Y', strtotime($monthlyPayment->due_date))}}</td>
                            <td>R$ {{number_format($monthlyPayment->total_payable, 2, ',', '.')}}</td>
                            <td>R$ {{number_format($monthlyPayment->amount_paid, 2, ',', '.')}}</td>
                            <td>R$ {{number_format($monthlyPayment->balance_value, 2, ',', '.')}}</td>
                            <td>
                                <div>
                                    <h6>-</h6>
                                </div>
                            </td>
                        </tr>
                        @elseif ($monthlyPayment->id_monthly_status === 'P')
                            <tr class="bg-secondary text-white">
                                <td>{{$monthlyPayment->id}}</td>
                                <td>{{$monthlyPayment->name_contractor}}</td>
                                <td>{{date('d/m/Y', strtotime($monthlyPayment->due_date))}}</td>
                                <td>R$ {{number_format($monthlyPayment->total_payable, 2, ',', '.')}}</td>
                                <td>R$ {{number_format($monthlyPayment->amount_paid, 2, ',', '.')}}</td>
                                <td>R$ {{number_format($monthlyPayment->balance_value, 2, ',', '.')}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="" class="mr-3 btn btn-sm btn-success" id="btn-low" data-id-monthly="{{$monthlyPayment->id}}" data-bs-toggle="modal" data-balance-value="{{number_format($monthlyPayment->balance_value, 2, ',', '.')}}" data-bs-target="#modal-low">Baixar</a>
                                    </div>
                                </td>
                            </tr>
                        @elseif($monthlyPayment->id_monthly_status === 'C')
                            <tr class="bg-danger text-white">
                                <td>{{$monthlyPayment->id}}</td>
                                <td>{{$monthlyPayment->name_contractor}}</td>
                                <td>{{date('d/m/Y', strtotime($monthlyPayment->due_date))}}</td>
                                <td>R$ {{number_format($monthlyPayment->total_payable, 2, ',', '.')}}</td>
                                <td>R$ {{number_format($monthlyPayment->amount_paid, 2, ',', '.')}}</td>
                                <td>R$ {{number_format($monthlyPayment->balance_value, 2, ',', '.')}}</td>
                                <td>
                                    <div>
                                        <h6>-</h6>
                                    </div>
                                </td>
                            </tr>
                        @else
                        <tr class="">
                            <td>{{$monthlyPayment->id}}</td>
                            <td>{{$monthlyPayment->name_contractor}}</td>
                            <td>{{$monthlyPayment->stores}}</td>
                            <td>{{$monthlyPayment->pavements}}</td>
                            <td>{{date('d/m/Y', strtotime($monthlyPayment->due_date))}}</td>
                            <td>R$ {{number_format($monthlyPayment->total_payable, 2, ',', '.')}}</td>
                            <td>R$ {{number_format($monthlyPayment->amount_paid, 2, ',', '.')}}</td>
                            <td>R$ {{number_format($monthlyPayment->balance_value, 2, ',', '.')}}</td>
                            <td>
                                @if($monthlyPayment->id_monthly_status === 'A' || $monthlyPayment->id_monthly_status === 'P')
                                <div class="d-flex">
                                    <a href="" class="mr-3 btn btn-sm btn-outline-success" id="btn-low" data-id-monthly="{{$monthlyPayment->id}}" data-balance-value="{{number_format($monthlyPayment->balance_value, 2, ',', '.')}}" data-bs-toggle="modal" data-bs-target="#modal-low">Baixar</a>
                                    @if ($monthlyPayment->id_monthly_status === 'A')
                                        <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-cancel" data-id-monthly="{{$monthlyPayment->id}}" data-bs-toggle="modal" data-bs-target="#modal-cancel">Cancelar</a>
                                    @endif
                                </div>
                            @endif
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center my-2">
            {{ $tuition->appends(request()->input())->links()}}
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

                <form action="{{route('monthly.lowerMonthlyFee')}}" method="post">
                    @csrf
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
                <form action="{{route('monthly.cancelTuition')}}" method="post">
                    @csrf
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
    </script>
@endsection
