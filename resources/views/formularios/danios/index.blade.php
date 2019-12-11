<form id="formDanios" action="{{ route('guardar-danio') }}" method="POST" >
        <div class="input-group mb-3">
            <input type="hidden" name="idFormulario" id="idFormulario" value="{{$formulario->id}}">
            <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre del daño ocasional" required>
            <div class="input-group-append">
              <button class="btn btn-dark" >Guardar</button>
            </div>
          </div>
    </form>
    @if ($formulario->danios->count()>0)
        <ul class="">
            @foreach ($formulario->danios as $danio)
                <li class="media">                
                    <div class="media-body">
                        * {{$danio->nombre}}                       
                    </div>
                    <div class="text-left">
                        <a onclick="eliminarDanio(this);" data-id="{{ $danio->id }}"  class="bg-white border-danger text-danger rounded-round border-2 ">
                            <i class="icon-bin"></i>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
    <div class="alert alert-danger" role="alert">
        No existen daños ocasionados asignados al formulario
    </div>
        
    @endif
    <script>
         $("#formDanios").submit(function(e){
            e.preventDefault();
            var values = $(this).serialize();
            var post_url = $(this).attr("action");
           
            $.ajax({
                url: post_url,
                type: "post",
                data: values ,
                success: function (res) {
                    notificar('success','Daño asignado al formulario');
                    cargarDanios();
                },
                error: function(xhr, status, error) {
                    notificar('error','NO se pudo crear el daño ocasional en el formulario verifique los datos y vuelva a intentar');
                    
                }
            });
        });
        function eliminarDanio(arg){
            
            swal({
                title: "¿Estás seguro?",
                text: "Que desea eliminar este daño ocasional !",
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
                $.post( "{{ route('eliminar-danio') }}", { danio: $(arg).data('id') })
                .done(function( data ) {
                    if(data.success){                    
                        notificar("info",data.success);
                        cargarDanios();
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