@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
                <h3 class="my-4 text-secondary text-center">Baixas</h3>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start my-5">
            <a href="{{route('monthly.tuition')}}" class="btn btn-lg btn-danger">Voltar</a>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle text-center">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>ID Estorno</td>
                        <td>Tipo de Pagamento</td>
                        <td>Valor Pago</td>
                        <td>Data de pagamento</td>
                        <td>Usuário da Baixa</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody id="body-table">
                    @foreach ($lowerMonthlyFees as $lowerMonthlyFee)
                        @if(!empty($lowerMonthlyFee->id_lower_monthly_fees_reverse) && $lowerMonthlyFee->operation_type === 'B')
                            <tr class="bg-secondary text-white">
                        @elseif ($lowerMonthlyFee->operation_type === 'B')
                            <tr class="bg-success text-white">
                        @elseif ($lowerMonthlyFee->operation_type === 'E')
                            <tr class="bg-danger text-white">
                        @endif
                            <td>{{$lowerMonthlyFee->id}}</td>
                            <td>{{$lowerMonthlyFee->id_lower_monthly_fees_reverse}}</td>
                            <td>{{$lowerMonthlyFee->type_payment}}</td>
                            <td>{{number_format($lowerMonthlyFee->amount_paid, 2, ',', '.')}}</td>
                            <td>@if ($lowerMonthlyFee->dt_payday)
                                {{Date('d/m/Y', strtotime($lowerMonthlyFee->dt_payday))}}
                            @elseif ($lowerMonthlyFee->dt_chargeback)
                                {{Date('d/m/Y', strtotime($lowerMonthlyFee->dt_chargeback))}}
                            @endif</td>
                            <td>
                                @if ($lowerMonthlyFee->operation_type === 'B')
                                    {{$lowerMonthlyFee->download_user}}
                                @elseif($lowerMonthlyFee->operation_type === 'E')
                                    {{$lowerMonthlyFee->chargeback_user}}
                                @endif
                            </td>
                            @if (!empty($lowerMonthlyFee->id_lower_monthly_fees_reverse))
                                <td> - </td>
                            @elseif(empty($lowerMonthlyFee->id_lower_monthly_fees_reverse))
                                @if ($lowerMonthlyFee->operation_type === 'B')
                                    @if(Auth::user()->user_type_service_order === 'E')
                                        <td><a href="" class="mr-3 btn btn-sm btn-danger" id="btn-reverse" data-id-lowerMonthlyFee="{{$lowerMonthlyFee->id}}" data-bs-toggle="modal" data-bs-target="#modal-reverse-low">Estornar</a></td>
                                    @else
                                        <td> - </td>
                                    @endif
                                @elseif($lowerMonthlyFee->operation_type === 'E')
                                    <td> - </td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                        <form id="reverseLowerMonthlyFee" action="{{route('monthly.reverseMonthlyPayment')}}" method="POST">
                            @csrf
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
        <script>
            $(document).delegate('#btn-reverse', 'click', function(){
                var id_lowerMonthlyFee = $(this).attr('data-id-lowerMonthlyFee');
                $('#id_lowerMonthlyFee').val(id_lowerMonthlyFee);
            })
        </script>
@endsection
