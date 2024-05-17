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
    <div class="container text-center" id="receipt">
        <h2 class="my-3">Recibo de Pagamento Parcial</h2>
        <h3>Mensalidade {{$monthlyPayment->id_monthly_payment}}</h3>
        <h4>Contrato {{$monthlyPayment->id_contract}} - Lojas - {{$monthlyPayment->stores}}</h4>
        <h4>Contratante: {{$monthlyPayment->name_contractor}}</h4>
        <h4>Valor Pago: R${{number_format($monthlyPayment->amount_paid, 2, ',', '.')}}</h4>
        <h4>Valor em Aberto R${{number_format($monthlyPayment->balance_value, 2, ',', '.')}}</h4>
        <h4>Data da Baixa: {{date('d/m/Y', strtotime($monthlyPayment->dt_payday_partial))}}</h4>
        <h4>Usuário do Recebimento: {{$monthlyPayment->download_user}}</h4>
    </div>
    <button onclick="printContent('receipt')" class="btn btn-primary">Imprimir</button>
    <script>
        function printContent(divId){
            var printContents = document.getElementById(divId).innerHTML;
            var printWindow = window.open('', '', 'height=600,width=800');

            printWindow.document.write('<html><head><title>Impressão</title>');
            printWindow.document.write('<style>body{font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; flex-direction: column;} h1{color: #333;} </style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');

            printWindow.document.onload();

            // printWindow.onload = function() {
            //     printWindow.print();
            //     printWindow.close();
            // };
        }
    </script>
</body>
</html>
