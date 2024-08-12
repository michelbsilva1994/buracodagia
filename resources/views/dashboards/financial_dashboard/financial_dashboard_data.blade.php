<div class="">
    <div class="row col-12 text-secondary text-center my-5">
        <div class="col-8">
            <canvas id="myChart">
            </canvas>
        </div>
        <div class="col-4 my-5">
            <div>
                <h3>Totais</h3>
                <h5>Valor Total: R$ {{number_format($dataTotalTuition_t[0], 2, ',', '.')}}</h5>
                <h5>Total Recebido: R$ {{number_format($dataTotalTuition_t[1], 2, ',', '.')}}</h5>
                <h5>Total à Receber: R$ {{number_format($dataTotalTuition_t[2], 2, ',', '.')}}</h5>
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
    <div class="row col-12 text-secondary text-center my-5" id="values">
            <div class="col-8">
                <canvas id="myChartLowers">
                </canvas>
            </div>
            <div class="col-4 my-5">
                <div>
                    <h3>Totais por Pavimento</h3>
                    <h5>Shopping Chão: R$ {{number_format($dataTotalTuition[0], 2 , ',', '.')}}</h5>
                    <h5>Sub-Solo: R$ {{number_format($dataTotalTuition[1], 2 , ',', '.')}}</h5>
                    <h5>Expansão: R$ {{number_format($dataTotalTuition[2], 2 , ',', '.')}}</h5>
                </div>
                <div class="mt-5">
                    <h3>Baixas por Pavimento</h3>
                    <h5>Shopping Chão: R$ {{number_format($totalLowerTuitionPavementOne, 2 , ',', '.')}}</h5>
                    <h5>Sub-Solo: R$ {{number_format($totalLowerTuitionPavementTwo, 2 , ',', '.')}}</h5>
                    <h5>Expansão: R$ {{number_format($totalLowerTuitionPavementThree, 2 , ',', '.')}}</h5>
                </div>
            </div>
    </div>
</div>
