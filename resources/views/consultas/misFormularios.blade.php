<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consultas</title>
    <link href="{{ asset('admin/font/fontawesome-free-5.9.0-web/css/all.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('admin/js/jquery.min.js') }}"></script>
	<script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="card">       
  
            @if ($formularios->count()>0)
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr class="text-center bg-info">
                            <th colspan="3">Mis formularios </th>

                        </tr>
                        <tr>
                            <th>
                                N°
                            </th>
                            <th>
                                Emergencia
                            </th>
                            <th>
                                Hora
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formularios as $formulario)
                        <tr>
                            <td>{{$formulario->numero}}</td>
                            <td>{{$formulario->emergencia->nombre}}</td>
                            <td>{{$formulario->horaSalida}}</td>
                        </tr>
                            
                        @endforeach
                    </tbody>
                </table>
          
            @else
                <div class="alert alert-danger" role="alert">
                    No tiene formularios para completar
                </div>
            @endif
    </div>
</body>
</html>