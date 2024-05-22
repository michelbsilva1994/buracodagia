<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container text-center">
        <h2>Buraco da Gia</h2>
        <h2 class="my-3">Recibo de Pagamento Total</h2>
        <h3>Mensalidade {{$monthlyPayment->id_monthly_payment}}</h3>
        <h4>Contrato {{$monthlyPayment->id_contract}} - Lojas - {{$monthlyPayment->stores}}</h4>
        <h4>Contratante: {{$monthlyPayment->name_contractor}}</h4>
        <h4>Total Pago: R${{number_format($monthlyPayment->amount_paid, 2, ',', '.')}}</h4>
        <h4>Data da Baixa: {{date('d/m/Y', strtotime($monthlyPayment->dt_payday))}}</h4>
        <h4>Usuário do Recebimento: {{$monthlyPayment->download_user}}</h4>
    </div>
</body>
</html>
