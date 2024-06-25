@extends('layout.app')
@section('content')
    <div class="container">
        <div class="my-3 d-flex text-secondary justify-content-center">
            <h3>Contratos:</h3><h3 class="ml-3">{{$physicalPerson->name}}</h3>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start my-3">
            <a href="{{route('physicalPerson.index')}}" class="btn btn-lg btn-danger mr-2">Voltar</a>
        </div>
        <div class="table-data">
            <div id="items-container">
                @include('contract.paginate.contract_person_data')
            </div>

            <div id="pagination-container">
                @include('contract.paginate.paginate_contract_person')
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection
