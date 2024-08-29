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

    <style>
        .font{
            font-size: 24pt;
        }
    </style>
</head>
<body>
    <div class="container text-center font">
        <h2>Buraco da Gia</h2>
        <h2 class="my-3">Recibo de Pagamento</h2>
        <h4>Pavimento: {{$monthlyPayment->pavements}}</h4>
        <h4>Nome do permissionario: {{$monthlyPayment->name_contractor}}</h4>
        <h4>{{$monthlyPayment->types_stores}}: {{$monthlyPayment->stores}}</h4>
        <h4>Tipo de Pagamento: {{$monthlyPayment->ds_type_payment}}</h4>
        <h4>Total Pago: R${{number_format($monthlyPayment->amount_paid, 2, ',', '.')}}</h4>
        <h4>Data do vencimento: {{date('d/m/Y', strtotime($monthlyPayment->due_date))}}</h4>
        <h4>Data da Baixa: {{date('d/m/Y', strtotime($monthlyPayment->dt_payday))}}</h4>
        <h4>Usuário: {{$monthlyPayment->download_user}}</h4>
        <h4>-----------------------------------------------</h4>
    </div>
</body>
</html>
