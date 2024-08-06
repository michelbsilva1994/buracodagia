<div class="row">
    <div class="row col-12 text-secondary text-center my-5">
        <div class="col-8">
            <canvas id="myChart">
            </canvas>
        </div>
        <div class="col-4 my-5">
            <div>
                <h3>Totais</h3>
                <h5>Valor Total: R$ {{number_format($total_receivable->total_payable, 2, ',', '.')}}</h5>
                <h5>Total Recebido: R$ {{number_format($total_paid->total_paid, 2, ',', '.')}}</h5>
                <h5>Total à Receber: R$ {{number_format($total_received->balance_value, 2, ',', '.')}}</h5>
            </div>
            <div class="mt-5">
                <h3>Valores Recebidos</h3>
                <h5>PIX: R$ {{number_format($pix, 2, ',', '.')}}</h5>
                <h5>Dinheiro: R$ {{number_format($money, 2, ',', '.')}}</h5>
                <h5>Cartão de Débito: R$ {{number_format($debit_card, 2, ',', '.')}}</h5>
                <h5>Cartão de Crédito: R$ {{number_format($credit_card, 2, ',', '.')}}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-12 text-secondary text-center my-3" id="values">
            <div class="mt-5 col-md-12 col-sm-12">
                <h3>Totais por Pavimento</h3>
                <h5>Shopping Chão: R$ {{number_format($totalTuitionPavementOne, 2 , ',', '.')}}</h5>
                <h5>Sub-Solo: R$ {{number_format($totalTuitionPavementTwo, 2 , ',', '.')}}</h5>
                <h5>Sub-Solo: R$ {{number_format($totalTuitionPavementThree, 2 , ',', '.')}}</h5>
            </div>
            <div class="mt-5 col-md-12 col-sm-12">
                <h3>Baixas por Pavimento</h3>
                <h5>Shopping Chão: R$ {{number_format($lowerTuitionPavementOne->total, 2 , ',', '.')}}</h5>
                <h5>Sub-Solo: R$ {{number_format($lowerTuitionPavementTwo->total, 2 , ',', '.')}}</h5>
                <h5>Sub-Solo: R$ {{number_format($lowerTuitionPavementThree->total, 2 , ',', '.')}}</h5>
            </div>
    </div>
</div>
