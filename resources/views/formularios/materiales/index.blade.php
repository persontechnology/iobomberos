<form id="formMateriales" action="{{ route('guardar-material') }}" method="POST" >
    <div class="input-group mb-3">
        <input type="hidden" name="formulario" id="formulario" value="{{$formulario->id}}">
        <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre del material" required>
        <div class="input-group-append">
          <button class="btn btn-dark" >Guardar</button>
        </div>
      </div>
</form>
@if ($formulario->materiales->count()>0)
    <ul class="">
        @foreach ($formulario->materiales as $material)
            <li class="media">                
                <div class="media-body">
                    * {{$material->nombre}}                       
                </div>
                <div class="text-left">
                    <a onclick="eliminarMaterial(this);" data-id="{{ $material->id }}"  class="bg-white border-danger text-danger rounded-round border-2 ">
                        <i class="icon-bin"></i>
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
@else
<div class="alert alert-danger" role="alert">
    No existen materiales asignados al formulario
</div>
    
@endif
<script>
     $("#formMateriales").submit(function(e){
        e.preventDefault();
        var values = $(this).serialize();
        var post_url = $(this).attr("action");
        $.ajax({
            url: post_url,
            type: "post",
            data: values ,
            success: function (res) {
                notificar('success','Material asignado al formulario');
                cargarMateriales();
            },
            error: function(xhr, status, error) {
                notificar('error','NO se pudo crear materiales en el formulario verifique los datos y vuelva a intentar');
                
            }
        });
    });
    function eliminarMaterial(arg){
        
        swal({
            title: "¿Estás seguro?",
            text: "Que desea eliminar este material !",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: "btn-dark",
            cancelButtonClass: "btn-danger",
            confirmButtonText: "¡Sí, bórralo!",
            cancelButtonText:"Cancelar",
            closeOnConfirm: false
        },
        function(){
            swal.close();
            $.blockUI({message:'<h1>Espere por favor.!</h1>'});
            $.post( "{{ route('eliminar-material') }}", { material: $(arg).data('id') })
            .done(function( data ) {
                if(data.success){                    
                    notificar("info",data.success);
                    cargarMateriales();
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