@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form class="col-12" id="form-filter">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_initial">Data Baixa Inicial</label>
                        <input type="date" name="date_initial" id="date_initial" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_final">Data Baixa Final</label>
                        <input type="date" name="date_final" id="date_final" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="pavement">Pavimento</label>
                        <select name="pavement" id="pavement" class="form-control">
                            <option value="">Selecione uma opção</option>
                            @foreach ($pavements as $pavement)
                                <option value="{{ $pavement->id }}">{{ $pavement->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                        <button type="submit" class="btn btn-lg btn-success" id="filter">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="items-container">
            @include('dashboards.financial_dashboard.financial_dashboard_lowers_data')
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#form-filter').on('submit', function(event) {
                event.preventDefault();
                var url = "{{ route('dashboardCharts.financialLowersDashboard') }}?" + $(this).serialize();
                fetchItems(url);
                window.history.pushState("", "", url);
            });
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            fetchItems(url);
            window.history.pushState("", "", url);
        });

        function fetchItems(url) {
            $.ajax({
                url: url,
                type: 'get',
                success: function(response) {
                    $('#items-container').html(response.html);
                    $('#pagination-container').html(response.pagination);
                },
                error: function(xhr) {
                    console.log('Error', xhr.statusText);
                }
            });
        }

        $(document).ready(function() {
            $('#items-container').empty();
        });

        $('#form-filter').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('dashboardCharts.financialLowersDashboard') }}",
                type: 'get',
                data: $(this).serialize(),
                success: function(response) {
                    //$('#values').removeClass('d-none');
                    $('#items-container').empty();
                    $('#items-container').html(response.html);
                }
            })
        });
    </script>
@endsection
