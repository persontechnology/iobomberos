@extends('layouts.app',['title'=>'Registro Pre-Hospitalaria '])

@section('breadcrumbs', Breadcrumbs::render('registroHospitalario',$formulario))
@section('barraLateral')

<div class="breadcrumb justify-content-center">
    <a href="{{ route('nueva-atencion',$formulario->id) }}" class="breadcrumb-elements-item">
        <i class="fas fa-plus"></i> Nuevo Registro
    </a>
   
    
</div>
@endsection
@section('content')
<div class="card">
    <div class="card-header text-center">
        Registros Pre-Hospitalaria del formulario N° <strong> {{$formulario->numero}} </strong>
    </div>
    <div class="card-body">
        <div class="row">
            @if ($formulario->atenciones->count()>0)
            @foreach ($formulario->atenciones as $atension)
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="data:image/jpeg;base64,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" alt="">

                        <div class="card-body">
                            <h5 class="card-title"><strong>Nombres: </strong>{{$atension->nombres}}</h5>
                            <p class="card-text"><strong>Cédula: </strong> {{$atension->cedula}} <br>
                                <strong> Edad: </strong> {{$atension->edad}}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent d-flex justify-content-between border-top-0 pt-0">
                                <span class="text-muted">Creado {{$atension->created_at->diffForHumans()}}</span>
								<ul class="list-inline mb-0">
                                    <li class="list-inline-item"><a href="{{route('editar-atencion',$atension->id)}}">Editar</a></li>
									<li class="list-inline-item "><a class="text-danger" href="#">Eliminar</a></li>
								</ul>
							</div>                       
                    </div>
                </div>
                
            @endforeach
                
            @else
                <div class="alert alert-danger" role="alert">
                    No existen registros Pre-Hospitalarios
                </div>
            @endif
        </div>
        <!-- /cards in grid columns -->

    </div>
</div>
@prepend('linksPie')
<script type="text/javascript">
    $('#menuGestionFomularios').addClass('nav-item-expanded nav-item-open');
     $('#menuFormularios').addClass('active');
</script>
@endprepend
@endsection