@if ($formulario->edificacion && $formulario->etapaIncendio && $formulario->tipoEdificacion)
<table class="table-border text-center">
    <tr>
        <th colspan="6">
                <h6 class="mt-1"><strong> USO DE EDIFICACIÓN.</strong></h6>
        </th>
    </tr>
    <tr>
        <th>
            Domestico
            <input class="mt-1" type="checkbox"  name="domestico" id="domestico" {{ old('domestico',$formulario->tipoEdificacion->domestico)=='1'?'checked':'' }}>
        </th>
        <th>
            Comercial
            <input class="mt-1" type="checkbox"  name="comercial" id="comercial" {{ old('comercial',$formulario->tipoEdificacion->comercial)=='1'?'checked':''}}>

        <th>
            Industrial
            <input class="mt-1" type="checkbox"  name="industrial" id="industrial" {{ old('industrial',$formulario->tipoEdificacion->industrial)=='1'?'checked':''}}>

        <th>
            Galpones
            <input class="mt-1" type="checkbox"  name="galpones" id="galpones" {{ old('galpones',$formulario->tipoEdificacion->galpones)=='1'?'checked':''}}>

    </tr>
</table>  
<table class="table-border text-center">
    <tr>
        <th colspan="6">
                <h6 class="mt-1"><strong> EDIFICACIÓN.</strong></h6>
        </th>
    </tr>
    <tr>
        <th>
            Tipo de construción    
        </th>
        <th>
            Madera
            <input class="mt-1" type="checkbox"  value="1" name="madera" id="madera" {{ old('madera',$formulario->edificacion->madera)=='1'?'checked':'' }}>
        </th>
        <th>
            Hormigón
            <input class="mt-1" type="checkbox"  value="1" name="hormigon" id="hormigon" {{ old('hormigon',$formulario->edificacion->hormigon)=='1'?'checked':'' }}>
        </th>
        <th>
            Mixta
            <input class="mt-1" type="checkbox"  value="1" name="mixta" id="mixta" {{ old('mixta',$formulario->edificacion->mixta)=='1'?'checked':'' }}>
        </th>
        <th>
            Metálica
            <input class="mt-1" type="checkbox"  value="1" name="metalica" id="metalica" {{ old('metalica',$formulario->edificacion->metalica)=='1'?'checked':'' }}>
        </th>
        <th>
            Adobe
            <input class="mt-1" type="checkbox"  value="1" name="adobe" id="adobe" {{ old('adobe',$formulario->edificacion->adobe)=='1'?'checked':'' }}>
        </th>                          

    </tr>

    <tr>
            <th>
                Número de plantas  
            </th>
            <th>
                Planta baja
                <input class="mt-1" type="checkbox"  value="1" name="plantaBaja" id="plantaBaja" {{ old('plantaBaja',$formulario->edificacion->plantaBaja)=='1'?'checked':'' }}>
            </th>
            <th>
                1 Planta
                <input class="mt-1" type="checkbox"  value="1" name="primerPiso" id="primerPiso" {{ old('primerPiso',$formulario->edificacion->primerPiso)=='1'?'checked':'' }}>
            </th>
            <th>
                2 Planta
                <input class="mt-1" type="checkbox"  value="1" name="segundoPiso" id="segundoPiso" {{ old('segundoPiso',$formulario->edificacion->segundoPiso)=='1'?'checked':'' }}>
            </th>
            <th>
                3 Planta
                <input class="mt-1" type="checkbox"  value="1" name="tercerPiso" id="tercerPiso" {{ old('tercerPiso',$formulario->edificacion->tercerPiso)=='1'?'checked':'' }}>
            </th>
            <th>
                Patio
                <input class="mt-1" type="checkbox"  value="1" name="patio" id="patio" {{ old('patio',$formulario->edificacion->patio)=='1'?'checked':'' }}>
            </th>                          

        </tr>
</table>
<table class="table-border text-center">
    <tr>
        <th colspan="6">
                <h6 class="mt-1"><strong> ETAPAS DE INCENDIO.</strong></h6>
        </th>
    </tr>
    <tr>
        <th>
            Incipiente
            <input class="mt-1" type="checkbox"  name="incipiente" id="incipiente" {{ old('incipiente',$formulario->etapaIncendio->incipiente)=='1'?'checked':'' }}>
        </th>
        <th>
            Desarrollo
            <input class="mt-1" type="checkbox"  name="desarrollo" id="desarrollo" {{ old('desarrollo',$formulario->etapaIncendio->desarrollo)=='1'?'checked':''}}>

        <th>
            Combustión libre
            <input class="mt-1" type="checkbox"  name="combustion" id="combustion" {{ old('combustion',$formulario->etapaIncendio->combustion)=='1'?'checked':''}}>

        <th>
            Flashover
            <input class="mt-1" type="checkbox"  name="flashover" id="flashover" {{ old('flashover',$formulario->etapaIncendio->flashover)=='1'?'checked':''}}>

        <th>
            Decadencia
            <input class="mt-1" type="checkbox"  name="decadencia" id="decadencia" {{ old('decadencia',$formulario->etapaIncendio->decadencia)=='1'?'checked':''}}>

        <th>
            Arder sin llama
            <input class="mt-1" type="checkbox"  name="arder" id="arder" {{ old('arder',$formulario->etapaIncendio->arder)=='1'?'checked':''}}>
        </th>
        

    </tr>
</table> 
<div class="mt-2 text-center">

    <a onclick="eliminarEdificacion(this)" data-id="{{ $formulario->id }}" class="btn btn-danger text-white">Eliminar tipo de edificación y etapas de incendio <i class="icon-bin  ml-2"></i> </a>      
</div>

@else                    
<a onclick="crearEdificacion(this)" data-id="{{ $formulario->id }}" class="btn btn-primary text-white">Crear tipo de edificación y etapas de incendio <i class="icon-office  ml-2"></i> </a>      
@endif

<script>

function eliminarEdificacion(arg){
        
        swal({
            title: "¿Estás seguro?",
            text: "Que desea eliminar edificación al formulario !",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: "btn-dark",
            cancelButtonClass: "btn-danger",
            confirmButtonText: "¡Sí, eliminar!",
            cancelButtonText:"Cancelar",
            closeOnConfirm: false
        },
        function(){
            swal.close();
            $.blockUI({message:'<h1>Espere por favor.!</h1>'});
            $.post( "{{ route('eliminar-edificacion-formulario') }}", { formulario: $(arg).data('id') })
            .done(function( data ) {
                if(data.success){
                    
                    notificar("info",data.success);
                    cargarEdificaciones();
                }
                if(data.default){
                    notificar("default",data.default);   
                }
                console.log(data)
            }).always(function(){
                $.unblockUI();
            }).fail(function(){
                notificar("error","Ocurrio un error");
            });

        });
    }
function crearEdificacion(arg){
        
        swal({
            title: "¿Estás seguro?",
            text: "Que desea crear edificación al formulario !",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: "btn-dark",
            cancelButtonClass: "btn-danger",
            confirmButtonText: "¡Sí, crear!",
            cancelButtonText:"Cancelar",
            closeOnConfirm: false
        },
        function(){
            swal.close();
            $.blockUI({message:'<h1>Espere por favor.!</h1>'});
            $.post( "{{ route('guardar-edificacion-formulario') }}", { formulario: $(arg).data('id') })
            .done(function( data ) {
                if(data.success){
                    
                    notificar("info",data.success);
                    cargarEdificaciones();
                }
                if(data.default){
                    notificar("default",data.default);   
                }
                console.log(data)
            }).always(function(){
                $.unblockUI();
            }).fail(function(){
                notificar("error","Ocurrio un error");
            });

        });
    }
</script>