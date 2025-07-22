@extends('layout.app')
@section('content')
    <div class="container">
        <h3 class="my-4 text-secondary text-center">Relatório Baixas</h3>
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form action="{{route('reports.lowersTuition')}}" method="post" class="col-sm-12 col-md-12 col-lg-12">
                <div class="col-sm-12 col-md-12 col-lg-12 row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_initial">Data Baixa Inicial</label>
                        <input type="date" name="due_date_initial" id="due_date_initial" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_final">Data Baixa Final</label>
                        <input type="date" name="due_date_final" id="due_date_final" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="pavement">Pavimento</label>
                        <select name="pavement" id="pavement" class="form-control">
                            <option value="">Selecione uma opção</option>
                            @foreach ( $pavements as $pavement)
                                <option value="{{$pavement->id}}">{{$pavement->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_final">Loja</label>
                        <select name="store" id="store" class="form-control">
                            <option value="">Selecione uma opção</option>
                            @foreach ($stores as $store )
                                <option value="{{$store->id}}">{{$store->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_final">Tipo de Pagamento</label>
                        <select name="type_payment" id="type_payment" class="form-control">
                            <option value="">Selecione uma opção</option>
                            @foreach ($type_payments as $type_payment)
                                <option value="{{$type_payment->value}}">{{$type_payment->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @csrf
                <div class="row">
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-center my-3">
                        <button type="submit" class="btn btn-lg btn-success">Gerar Relatório</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script>
$(document).ready(function() {
    $('#pavement').on('change', function() {
        let pavementId = $(this).val();
        let url = "{{route('reports.storesByPavement', ['pavement_id' => ':id'])}}";
        url = url.replace(':id', pavementId);

        $.get(url, function(data) {
            let $storeSelect = $('#store');
            $storeSelect.empty(); // limpa as opções

            $storeSelect.append('<option value="">Selecione uma opção</option>');

            $.each(data, function(key, store) {
                $storeSelect.append('<option value="' + store.id + '">' + store.name + '</option>');
            });
        });
    });
});
</script>

@endsection
