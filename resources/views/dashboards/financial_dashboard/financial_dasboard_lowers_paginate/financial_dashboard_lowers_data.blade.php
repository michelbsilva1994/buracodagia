    <div class="col-12 table-responsive py-5    ">
        <table class="table align-middle text-center table-success table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Contrante</td>
                    <td>Pavimento</td>
                    <td>Lojas</td>
                    <td>Tipo de Pagamento</td>
                    <td>Valor Pago</td>
                    <td>Data de pagamento</td>
                    <td>Usuário da Baixa</td>
                </tr>
            </thead>
            <tbody id="body-table">
                @foreach ($lowersByPaymentType as $lowerMonthlyFee)
                    <tr>
                        <td>{{ $lowerMonthlyFee->id }}</td>
                        <td>{{ $lowerMonthlyFee->contractor }}</td>
                        <td>{{ $lowerMonthlyFee->pavement }}</td>
                        <td>{{ $lowerMonthlyFee->stores }}</td>
                        <td>{{ $lowerMonthlyFee->type_payment }}</td>
                        <td>{{ number_format($lowerMonthlyFee->amount_paid, 2, ',', '.') }}</td>
                        <td>{{ Date('d/m/Y', strtotime($lowerMonthlyFee->dt_payday)) }}</td>
                        <td>{{ $lowerMonthlyFee->download_user }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
