@extends('layouts.app',['title'=>'estadisticas'])

@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Line multiples</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <canvas id="myChart" width="400" height="400"></canvas>
    </div>
</div>
@push('linksCabeza')
{{--  datatable  --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
@endpush

@prepend('linksPie')

<script>

    var COLORS = [
		'#4dc9f6',
		'#f67019',
		'#f53794',
		'#537bc4',
		'#acc236',
		'#166a8f',
		'#00a950',
		'#58595b',
		'#8549ba'
	];
    var ctx = document.getElementById('myChart').getContext('2d');
    @php
        $i=0;
    @endphp
    var myChart = new Chart(ctx, {
        // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'],
        datasets: [
            @foreach ($emergencias as $emergencia)
            @php
                $i++;
                $contdor=$emergencia->formularios()->where('fecha','like','%'.labels[0].'%')->count();
            @endphp
                {
                    label: '{{ $emergencia->nombre }}',
                    
                    borderColor: COLORS[{{ $i }}],
                    data: [0, 10, 5, 2, 20, 30, 45]
                },
                
            @endforeach
        ],
     

    }
    });
    </script>
@endprepend


@endsection