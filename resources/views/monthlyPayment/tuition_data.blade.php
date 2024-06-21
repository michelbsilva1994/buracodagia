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
            @foreach ($tuition as $monthly)
                <tr>
                    <td>{{$monthly->pavements}}</td>
                    <td>{{$monthly->stores}}</td>
                    <td>{{$monthly->due_date}}</td>
                    <td>{{$monthly->name_contractor}}</td>
                    <td>{{$monthly->total_payable}}</td>
                    <td>{{$monthly->amount_paid}}</td>
                    <td>{{$monthly->balance_value}}</td>
                    <td>ações</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
