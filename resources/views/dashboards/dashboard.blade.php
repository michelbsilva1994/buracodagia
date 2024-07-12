@extends('layout.app')
@section('content')
    <div class="container">
        <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
            <form class="col-12" id="form-filter">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_initial">Data Vencimento Inicial</label>
                        <input type="date" name="due_date_initial" id="due_date_initial" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label for="due_date_final">Data Vencimento Final</label>
                        <input type="date" name="due_date_final" id="due_date_final" class="form-control">
                    </div>
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                        <button type="submit" class="btn btn-lg btn-success" id="filter">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="dashboard-data">
            <div id="items-container">
                @include('dashboards.financial_dashboard.financial_dashboard_data')
            </div>
        </div>
    </div>
    <script>
            $(document).ready(function(){
                $('#items-container').empty();
            });

            $('#form-filter').on('submit',function(event) {
                event.preventDefault();
                $.ajax({
                    url: "{{ route('dashboardCharts.dashboardCharts') }}",
                    type: 'get',
                    data: $(this).serialize(),
                    success: function(response) {
                        // $('#values').removeClass('d-none');
                        $('#items-container').empty();
                        $('#items-container').html(response.html);
                        var labels = response.items.labels.map(function(e) {
                            console.log(e);
                            return e;
                        });

                        var data = response.items.datasets[0].values.map(function(e) {
                            console.log(e);
                            return e;
                        });

                        var ctx = $('#myChart');
                        var config = {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Valores Recebidos',
                                    data: data,
                                    backgroundColor: [
                                        '#227093',
                                        '#218c74',
                                        '#84817a',
                                        '#2c2c54'
                                    ]
                                }]
                            }
                        };
                        var chart = new Chart(ctx, config);
                    }
                })
            });
    </script>
@endsection
