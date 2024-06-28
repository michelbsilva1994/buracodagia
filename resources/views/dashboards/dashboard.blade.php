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
                        <label for="due_date_final">Data Vencimento Inicial</label>
                        <input type="date" name="due_date_final" id="due_date_final" class="form-control">
                    </div>
                    <div class="d-grid gap-2 d-lg-flex justify-content-lg-end my-3">
                        <button type="submit" class="btn btn-lg btn-success" id="filter">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="dashboard-data">
            <div class="col-md-6 col-lg-6 col-sm-12">
                <canvas id="myChart">

                </canvas>
            </div>
            <div id="items-container">
                @include('dashboards.financial_dashboard.financial_dashboard_data')
            </div>
        </div>
    </div>
    <script>
        // $(document).ready(function() {
        //     $('#form-filter').on('submit', function(event) {
        //         event.preventDefault();
        //         var url = "{{ route('dashboardCharts.dashboardCharts') }}?" + $(this).serialize();
        //         fetchItems(url);
        //         window.history.pushState('', '', url);
        //     });
        // });

        // function fetchItems(url) {
        //     $.ajax({
        //         url: url,
        //         type: 'get',
        //         success: function(response) {
        //             console.log(response.html);
        //             $('#items-container').html(response.html);
        //         },
        //         error: function(xhr) {
        //             console.log('Error', xhr.statusText);
        //         }
        //     });
        // }

        $(document).ready(function() {
            $('#form-filter').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: "{{ route('dashboardCharts.dashboardCharts') }}",
                    type: 'get',
                    data: $(this).serialize(),
                    success: function(response) {
                        //console.log(response.items.datasets[0].values);
                        $('#items-container').html(response.html);
                        var labels = response.items.labels.map(function(e) {
                            //console.log(e);
                            return e;
                        });

                        var data = response.items.datasets[0].values.map(function(e) {
                            //console.log(e);
                            return e;
                        });
                        var itemDash = $('#myChart');
                            itemDash.empty();

                        var ctx = itemDash;
                        var config = {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Transaksi Status',
                                    data: data,
                                    backgroundColor: 'rgba(75, 192, 192, 1)',

                                }]
                            }
                        };
                        var chart = new Chart(ctx, config);
                    }
                })
            });
        });
    </script>
@endsection
