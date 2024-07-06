@extends('layout.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
              <h6>Nº Ordem de Serviço: {{$serviceOrder->id}}</h6>
              <h6>Solicitante: {{$user_requester->name}}</h6>
              <h6>Executor: {{$user_executor->name}}</h6>
              <h6>Data Abertura: {{Date('d/m/Y', strtotime($serviceOrder->dt_opening))}}</h6>
              <h6>Data Processo: {{Date('d/m/Y', strtotime($serviceOrder->dt_process))}}</h6>
              <h6>Data Encerramento: {{Date('d/m/Y', strtotime($serviceOrder->dt_service))}}</h6>
              <h6>Executor: {{$user_executor->name}}</h6>
              @if ($serviceOrder->id_status == 'A' && empty($serviceOrder->dt_proccess) && empty($serviceOrder->dt_serivce))
                        <h6>Status: Aberta</h6>
                    @elseif ($serviceOrder->id_status == 'P' && !empty($serviceOrder->dt_process) && empty($serviceOrder->dt_serivce))
                        <h6>Status: Em processo</h6>
                    @elseif ($serviceOrder->id_status == 'F' && !empty($serviceOrder->dt_service))
                        <h6>Status: Fechada</h6>
                    @endif
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
              <h4 class="text-center">{{$serviceOrder->title}}</h4>
            </div>
        </div>
        <div>
            <form action="{{route('serviceOrders.storeHistory', ['serviceOrder' => $serviceOrder->id])}}" method="post" class="mt-4 row" autocomplete="off">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <label for="description" class="text-secondary">Histórico</label>
                    <textarea class="form-control" name="description" id="description" cols="" rows="4">{{old('description')}}</textarea>
                    @error('description')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end my-3">
                    <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                </div>
            </form>
        </div>
        <div class="card my-3">
            <div class="card-body">
                <h4 class="text-center">Históricos</h4>
                <hr>
                @foreach ($serviceOrderHistory as $history )
                    <small>{{$history->create_user}}</small>
                    <h5 class="alert alert-secondary">{{$history->history}}</h5>
                @endforeach
            </div>
        </div>
    </div>
@endsection
