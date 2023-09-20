@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-12">
            <h3 class="my-4 text-secondary text-center">Mensalidades</h3>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('alert'))
            <div class="alert alert-warning" role="alert">
                {{ session('alert') }}
            </div>
        @endif
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form action="{{route('monthly.filter')}}" class="col-12" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="contractor">Contrante</label>
                        <input type="text" name="contractor" id="contractor" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date">Data Vencimento</label>
                        <input type="date" name="due_date" id="due_date" class="form-control">
                    </div>
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                        <button type="submit" class="btn btn-lg btn-success">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <td>Nº Mensalidade</td>
                        <td>Contrante</td>
                        <td>Data de vencimento</td>
                        <td>Valor a pagar</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tuition as $monthlyPayment)
                    <tr>
                        <td>{{$monthlyPayment->id}}</td>
                        <td>{{$monthlyPayment->name_contractor}}</td>
                        <td>{{date('d/m/Y', strtotime($monthlyPayment->due_date))}}</td>
                        <td>R$ {{$monthlyPayment->total_payable}}</td>
                        <td>
                            @if(empty($monthlyPayment->dt_payday) && empty($monthlyPayment->dt_cancellation))
                                <div class="d-flex">
                                    <a href="" class="mr-3 btn btn-sm btn-outline-success" id="btn-low" data-id-monthly="{{$monthlyPayment->id}}" data-bs-toggle="modal" data-bs-target="#modal-low">Baixar</a>
                                    <a class="mr-3 btn btn-sm btn-outline-danger" href="{{route('monthly.cancelTuition', ['monthlyPayment' => $monthlyPayment->id])}}">Cancelar</a>
                                </div>
                            @else
                                <div>
                                    <h6>-</h6>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-low" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel">Excluir</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('monthly.lowerMonthlyFee')}}" method="post">
                    @csrf
                    <div>
                        <input type="hidden" name="id_monthly" id="id_monthly">
                    </div>
                    <div>
                        <label for="dt_payday">Data da baixa</label>
                        <input type="date" name="dt_payday" id="dt_payday" class="form-control" required>
                    </div>
                    <div>
                        <label for="id_payment">Forma de pagamento</label>
                        <select name="id_payment" id="id_payment" class="form-control" required>
                            <option value="" disabled selected>Selecione uma opção</option>
                            @foreach ($typesPayments as $typePayment)
                                <option value="{{$typePayment->description}}">{{$typePayment->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2 my-3">
                        <button type="submit" class="btn btn-success" id="btn-low-monthly">Baixar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
    </div>
    <script>
        $(document).delegate('#btn-low','click',function(){
            var id_monthly = $(this).attr('data-id-monthly');
            $('#id_monthly').val(id_monthly);
        });
    </script>
@endsection
