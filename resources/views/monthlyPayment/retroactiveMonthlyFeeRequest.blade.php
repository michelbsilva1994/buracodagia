@extends('layout.app')
@section('content')
    <div class="container">
        @can('generate_retroactive_monthly_payment')
            <hr>
            <div class="col-12">
                <h3 class="my-4 text-secondary text-center">Geração de Mensalidade Retroativa por Contrato</h3>
            </div>
            <div class="col-sm-12 d-md-flex justify-content-md-center">
                <form action="{{route('monthly.generateRetroactiveMonthlyPayment')}}" method="post" class="col-sm-12 col-md-12 col-lg-10">
                    @csrf
                    <div class="col-sm-12 col-md-8 mx-auto">
                        <label for="due_date" class="form-label">Data de Vencimento</label>
                        <input type="date" name="due_date" id="due_date" class="form-control">
                        @error('due_date')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-12 col-md-8 mx-auto">
                        <label for="contract">Contrato</label>
                        <select name="contract" id="contract" class="form-control">
                            <option value="">Selecione uma opção</option>
                            @foreach ( $contracts as $contract)
                                <option value="{{$contract->id}}">{{$contract->name_contractor}}</option>
                            @endforeach
                        </select>
                        @error('contract')<div class="alert alert-danger p-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center my-3">
                        <input type="submit" class="btn btn-lg btn-success" value="Gerar Mensalidade">
                        {{-- <button type="submit" class="btn btn-lg btn-success">Gerar Mensalidade</button> --}}
                    </div>
                </form>
            </div>
        @endcan
    </div>
@endsection
