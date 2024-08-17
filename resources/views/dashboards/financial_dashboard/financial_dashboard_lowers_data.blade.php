<div class="">
    <div class="row col-12 text-secondary text-center mt-3">
        <div class="col-12">
            <div class="card text-center py-4 bg-brown text-white">
                <h5 class="card-title">Valor Total Recebido</h5>
                <h2> R$ {{number_format($totalLowers, 2, ',', '.')}}</h2>
            </div>
        </div>
        {{-- <div class="col-8">
            <canvas id="myChart">
            </canvas>
        </div> --}}
        <div class="row col-12 pt-5">
            <div class="my-2"><h3>Baixas por Pavimento</h3></div>
            <div class="col-sm-12 col-md-4 py-2">
                <div>
                    <div class="card text-center bg-dark-blue text-white">
                        <h5 class="card-title pt-2">Shopping Chão</h5>
                        <h2>R$ {{number_format($totalLowerTuitionPavement[0], 2 , ',', '.')}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 py-2">
                <div>
                    <div class="card text-center bg-dark-blue text-white">
                        <h5 class="card-title pt-2">Sub-Solo</h5>
                        <h2>R$ {{number_format($totalLowerTuitionPavement[1], 2 , ',', '.')}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 py-2">
                <div>
                    <div class="card text-center bg-dark-blue text-white">
                        <h5 class="card-title pt-2">Expansão</h5>
                        <h2>R$ {{number_format($totalLowerTuitionPavement[2], 2 , ',', '.')}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-12 pt-5">
            <div class="my-2"><h3>Valores Recebidos</h3></div>
            <div class="col-sm-12 col-md-3 py-2">
                <div>
                    <div class="card text-center bg-dark-green text-white">
                        <h5 class="card-title pt-2">Dinheiro</h5>
                        <h2>R$ {{number_format($money, 2 , ',', '.')}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 py-2">
                <div>
                    <div class="card text-center bg-dark-green text-white">
                        <h5 class="card-title pt-2">PIX</h5>
                        <h2>R$ {{number_format($pix, 2 , ',', '.')}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 py-2">
                <div>
                    <div class="card text-center bg-dark-green text-white">
                        <h5 class="card-title pt-2">Cartão de Débito</h5>
                        <h2>R$ {{number_format($debit_card, 2 , ',', '.')}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 py-2">
                <div>
                    <div class="card text-center bg-dark-green text-white">
                        <h5 class="card-title pt-2">Cartão de Crédito</h5>
                        <h2>R$ {{number_format($credit_card, 2 , ',', '.')}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
