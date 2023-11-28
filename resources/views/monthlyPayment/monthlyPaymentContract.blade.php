@extends('layout.app')
@section('content')
    <div class="container">
        <div class="my-4 text-secondary text-center">
            <h3>Mensalidades</h3>
            <h2>Contrato: {{$contract->id}}</h2>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start my-3">
            <a href="{{route('physical.contractPerson', ['id_person' => $contract->id])}}" class="btn btn-lg btn-danger mr-2">Voltar</a>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>Nº Mensalidade</td>
                        <td>Data de vencimento</td>
                        <td>Valor a pagar</td>
                        <td>Valor Pago</td>
                        <td>Saldo</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlyPayment as $monthly)
                        @if ($monthly->id_monthly_status === 'F')
                            <tr class="bg-success text-white">
                                <td>{{$monthly->id}}</td>
                                <td>{{date('d/m/Y', strtotime($monthly->due_date))}}</td>
                                <td>R$ {{number_format($monthly->total_payable, 2, ',', '.')}}</td>
                                <td>R$ {{number_format($monthly->amount_paid, 2, ',', '.')}}</td>
                                <td>R$ {{number_format($monthly->balance_value, 2, ',', '.')}}</td>
                                <td>
                                    @if($monthly->id_monthly_status === 'A' || $monthly->id_monthly_status === 'P')
                                        <div class="d-flex">
                                            <a href="" class="mr-3 btn btn-sm btn-outline-success" id="btn-low" data-id-monthly="{{$monthly->id}}" data-bs-toggle="modal" data-bs-target="#modal-low">Baixar</a>
                                                <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-cancel" data-id-monthly="{{$monthly->id}}" data-bs-toggle="modal" data-bs-target="#modal-cancel">Cancelar</a>
                                        </div>
                                    @else
                                        <div>
                                            <h6>-</h6>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @elseif ($monthly->id_monthly_status === 'P')
                            <tr class="bg-secondary text-white">
                                <td>{{$monthly->id}}</td>
                                <td>{{date('d/m/Y', strtotime($monthly->due_date))}}</td>
                                <td>R$ {{number_format($monthly->total_payable, 2, ',', '.')}}</td>
                                <td>R$ {{number_format($monthly->amount_paid, 2, ',', '.')}}</td>
                                <td>R$ {{number_format($monthly->balance_value, 2, ',', '.')}}</td>
                                <td>
                                    @if(empty($monthly->dt_payday) && empty($monthly->dt_cancellation))
                                        <div class="d-flex">
                                            <a href="" class="mr-3 btn btn-sm btn-success" id="btn-low" data-id-monthly="{{$monthly->id}}" data-bs-toggle="modal" data-bs-target="#modal-low">Baixar</a>
                                        </div>
                                    @else
                                        <div>
                                            <h6>-</h6>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @elseif($monthly->id_monthly_status === 'C')
                            <tr class="bg-danger text-white">
                                <td>{{$monthly->id}}</td>
                                <td>{{date('d/m/Y', strtotime($monthly->due_date))}}</td>
                                <td>R$ {{number_format($monthly->total_payable, 2, ',', '.')}}</td>
                                <td>R$ {{number_format($monthly->amount_paid, 2, ',', '.')}}</td>
                                <td>R$ {{number_format($monthly->balance_value, 2, ',', '.')}}</td>
                                <td>
                                    @if(empty($monthly->dt_payday) && empty($monthly->dt_cancellation))
                                        <div class="d-flex">
                                            <a href="" class="mr-3 btn btn-sm btn-outline-success" id="btn-low" data-id-monthly="{{$monthly->id}}" data-bs-toggle="modal" data-bs-target="#modal-low">Baixar</a>
                                            <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-cancel" data-id-monthly="{{$monthly->id}}" data-bs-toggle="modal" data-bs-target="#modal-cancel">Cancelar</a>
                                        </div>
                                    @else
                                        <div>
                                            <h6>-</h6>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @else
                        <tr class="">
                            <td>{{$monthly->id}}</td>
                            <td>{{date('d/m/Y', strtotime($monthly->due_date))}}</td>
                            <td>R$ {{number_format($monthly->total_payable, 2, ',', '.')}}</td>
                            <td>R$ {{number_format($monthly->amount_paid, 2, ',', '.')}}</td>
                            <td>R$ {{number_format($monthly->balance_value, 2, ',', '.')}}</td>
                            <td>
                                @if(empty($monthly->dt_payday) && empty($monthly->dt_cancellation))
                                    <div class="d-flex">
                                        <a href="" class="mr-3 btn btn-sm btn-outline-success" id="btn-low" data-id-monthly="{{$monthly->id}}" data-bs-toggle="modal" data-bs-target="#modal-low">Baixar</a>
                                        <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-cancel" data-id-monthly="{{$monthly->id}}" data-bs-toggle="modal" data-bs-target="#modal-cancel">Cancelar</a>
                                    </div>
                                @else
                                    <div>
                                        <h6>-</h6>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
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

                <form action="{{route('monthly.lowerMonthlyFeeContract')}}" method="post">
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
                            <option value="" disabled selected>Selecione uma opção</option>
                            @foreach ($typesPayments as $typePayment)
                                <option value="{{$typePayment->value}}">{{$typePayment->description}}</option>
                            @endforeach
                        </select>
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
                <form action="{{route('monthly.cancelTuitionContract')}}" method="post">
                    @csrf
                    <div>
                        <input type="hidden" name="id_monthly_cancel" id="id_monthly_cancel">
                    </div>
                    <div>
                        <label for="dt_cancellation">Data da Cancelamento</label>
                        <input type="date" name="dt_cancellation" id="dt_cancellation" class="form-control" required>
                    </div>
                    <div>
                        <label for="id_cancellation">Forma de pagamento</label>
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
    </script>
@endsection
