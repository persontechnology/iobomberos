@extends('layouts.app',['title'=>'estadisticas'])

@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Estadísticas</h5>
        <form action="{{ route('generarEstadisticas') }}"  method="get">
            <div class="input-group mb-3">
                <input type="date" name="fecha" value="{{ $fecha??'' }}" class="form-control" placeholder="Fecha" aria-label="Fecha" aria-describedby="basic-addon2" required>
                <div class="input-group-append">
                    <button class="btn btn-dark" type="submit">Buscar </button>
                </div>
            </div>
        </form>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        @if ($fecha)
            
            <div class="row">
                <div class="col-sm-12">
                    {{--  <canvas id="myChart" height="100"></canvas>  --}}
                    <figure class="highcharts-figure">
                        <div id="containerLinea"></div>
                        
                    </figure>
                    
                </div>
                <div class="col-sm-12">
                    <figure class="highcharts-figure">
                        <div id="containerBar"></div>
                        
                    </figure>
                </div>   


            </div>
        @else
        <div class="alert alert-danger" role="alert">
            No se existen datos
        </div>
            
        @endif
    </div>
</div>
@push('linksCabeza')
{{--  datatable  --}}
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

@endpush

@prepend('linksPie')
<script>

$('#menuEstadisticas').addClass('nav-item-expanded nav-item-open');
$('#menuEstadisticas').addClass('active');
Highcharts.chart('containerLinea', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Total Emergencias'
    },
    subtitle: {
        text: 'Total de emergencias en el año {{date('Y',strtotime($fecha))}}'
    },
    xAxis: {
        categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Séptiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Emergencias (E)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} E</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        @foreach ($emergencias as $emergencia)
            {
            name: '{{$emergencia->nombre}}',
            data: [
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,1) }},
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,2) }},
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,3) }},
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,4) }},
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,5) }},
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,6) }},
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,7) }},
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,8) }},
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,9) }},
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,10) }},
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,11) }},
                {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,12) }},
                
            ]

            },
        @endforeach
    ]
});


Highcharts.chart('containerBar', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Browser market shares in January, 2018'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
            @foreach ($emergencias as $emergencia)
                {
                    name: '{{$emergencia->nombre}}',
                    y: {{ $emergencia->formularioPastel($emergencia->id,$fecha) }},
                    sliced: true,
                    selected: true
                },
            @endforeach
            ]
    }]
});
</script>
<script>
    {{--  var colors = ['#007bff','#28a745','#333333','#3F51B5','#dc3545','#6c757d'];
    var bacColor= ['#29B0D0','#2A516E','#F07124','#CBE0E3','#979193'];
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Séptiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            @php
                $i=0;
            @endphp
            datasets: [
                @foreach ($emergencias as $emergencia)
                {
                    label:'{{$emergencia->nombre}}',
                    data: [
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,1) }},
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,2) }},
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,3) }},
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,4) }},
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,5) }},
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,6) }},
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,7) }},
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,8) }},
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,9) }},
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,10) }},
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,11) }},
                            {{ $emergencia->formulariosEstadisticas($emergencia->id,$fecha,12) }},
                            
                        ],
                    backgroundColor: bacColor[{{ $i }}],
                    borderColor: colors[{{ $i }}],
                    borderWidth: 2,
                    pointBackgroundColor: colors[0]
                },
                @php
                    $i++;
                @endphp
                @endforeach
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });  --}}
    </script>
@endprepend


@endsection