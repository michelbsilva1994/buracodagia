@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12 table-responsive">
            <table class="table align-middle text-center">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>Tipo de Pagamento</td>
                        <td>Valor Pago</td>
                        <td>Data de pagamento</td>
                        <td>Usuário da Baixa</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody id="body-table">
                    @foreach ($lowerMonthlyFees as $lowerMonthlyFee)
                        <tr>
                            <td>{{$lowerMonthlyFee->id}}</td>
                            <td>{{$lowerMonthlyFee->type_payment}}</td>
                            <td>{{number_format($lowerMonthlyFee->amount_paid, 2, ',', '.')}}</td>
                            <td>@if ($lowerMonthlyFee->dt_payday)
                                {{Date('d/m/Y', strtotime($lowerMonthlyFee->dt_payday))}}
                            @elseif ($lowerMonthlyFee->dt_chargeback)
                                {{Date('d/m/Y', strtotime($lowerMonthlyFee->dt_chargeback))}}
                            @endif</td>
                            <td>{{$lowerMonthlyFee->download_user}}</td>
                            <td><a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-reverse" data-id-lowerMonthlyFee="{{$lowerMonthlyFee->id}}" data-bs-toggle="modal" data-bs-target="#modal-reverse-low">Estornar</a></td>
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
