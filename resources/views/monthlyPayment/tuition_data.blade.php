<div class="col-12 table-responsive">
    <table class="table align-middle text-center">
        <thead>
            <tr>
                <td>ID</td>
                <td>Pavimentos</td>
                <td>Lojas</td>
                <td>Data de vencimento</td>
                <td>Contratante</td>
                <td>Valor a pagar</td>
                <td>Valor Pago</td>
                <td>Saldo</td>
                <td>Ações</td>
            </tr>
        </thead>
        <tbody id="body-table">
            @foreach ($tuition as $monthly)
                <tr @if ($monthly->id_monthly_status === 'F')
                        class="bg-success"
                    @elseif($monthly->id_monthly_status === 'P')
                        class="bg-secondary"
                    @elseif($monthly->id_monthly_status === 'C')
                        class="bg-danger"
                    @else
                        class=""
                    @endif
                    >
                    <td>{{$monthly->id}}</td>
                    <td>{{$monthly->pavements}}</td>
                    <td>{{$monthly->stores}}</td>
                    <td>{{date('d/m/Y', strtotime($monthly->due_date))}}</td>
                    <td>{{$monthly->name_contractor}}</td>
                    <td>R$ {{number_format($monthly->total_payable, 2, ',', '.')}}</td>
                    <td>R$ {{number_format($monthly->amount_paid, 2, ',', '.')}}</td>
                    <td>R$ {{number_format($monthly->balance_value, 2, ',', '.')}}</td>
                    <td>
                    @if ($monthly->id_monthly_status === 'F')
                        <div class="d-flex">
                            <a href="{{route('pdfReports.receipt', ['id_receipt' => $monthly->id])}}" class="mr-3 btn btn-sm btn-primary" target="_blank">Recibo</a>
                            <a href="{{route('monthly.lowerMonthlyFeeIndex', ['id_monthly' => $monthly->id])}}" class="btn btn-sm btn-light">Baixas</a>
                        </div>
                    @elseif($monthly->id_monthly_status === 'P')
                        <div class="d-flex">
                            @if (Auth::user()->user_type_service_order === 'U')
                                <a href="{{route('pdfReports.partialReceipt', ['id_receipt' => $monthly->id])}}" class="mr-3 btn btn-sm btn-primary" target="_blank">Recibo</a>
                            @endif
                            @if (Auth::user()->user_type_service_order === 'E')
                                <a href="{{route('pdfReports.partialReceipt', ['id_receipt' => $monthly->id])}}" class="mr-3 btn btn-sm btn-primary" target="_blank">Recibo</a>
                                <a href="" class="mr-3 btn btn-sm btn-success" id="btn-low" data-id-monthly="{{$monthly->id}}" data-bs-toggle="modal" data-balance-value="{{number_format($monthly->balance_value, 2, ',', '.')}}" data-bs-target="#modal-low">Baixar</a>
                                <a href="{{route('monthly.lowerMonthlyFeeIndex', ['id_monthly' => $monthly->id])}}" class="btn btn-sm btn-light">Baixas</a>
                            @endif
                        </div>
                    @elseif($monthly->id_monthly_status === 'C')
                        <div class="d-flex text-white">
                            -
                        </div>
                    @else
                        @if (Auth::user()->user_type_service_order === 'U')
                            -
                        @endif
                        @if (Auth::user()->user_type_service_order === 'E')
                        <div class="d-flex">
                            <a href="" class="mr-3 btn btn-sm btn-outline-success" id="btn-low" data-id-monthly="{{$monthly->id}}" data-bs-toggle="modal" data-balance-value="{{number_format($monthly->balance_value, 2, ',', '.')}}" data-bs-target="#modal-low">Baixar</a>
                            <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-cancel" data-id-monthly="{{$monthly->id}}" data-bs-toggle="modal" data-bs-target="#modal-cancel">Cancelar</a>
                        </div>
                        @endif
                    @endif</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
