@extends('layouts.template')
@section('content')
    <div id="chart" style="max-width: 900px">

    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var options = {
            chart: {
                type: 'bar'
            },
            plotOptions: {
                bar: {
                    horizontal: false
                }
            },
            series: [{
                data: [{
                        x: 'Report',
                        y: {{ $report }},
                        fillColor: '#008FFB' // Warna default untuk 'Report'
                    },
                    {
                        x: 'Response',
                        y: {{ $response }},
                        fillColor: '#FF0000' // Warna merah untuk 'Response'
                    }
                ]
            }],
            colors: ['#008FFB', '#FF0000'], // Warna default jika dibutuhkan
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>
@endsection
