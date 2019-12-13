@if ($formulario->anexos->count()>0)
<div class="row">
    @php
        $i=0;
    @endphp
        @foreach ($formulario->anexos as $anexo)
        @php
            $i++;
        @endphp
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-img-actions">
                     <div class="d-flex align-items-center">                  
                               
                                   <div class="mr-2">
                                       <div class="card-img-top img-fluid">
                                           <a href="{{ Storage::url($anexo->foto) }}" data-fancybox="gallery" data-caption="Anexo">
                                               <img  width="100%" height="150px" src="{{ Storage::url($anexo->foto) }}" alt="">
                                               <span class="card-img-actions-overlay card-img">
                                                   <i class="icon-plus3"></i>
                                               </span>
                                           </a>
                                       </div>										
                                   </div>
                             
                       
                           </div>
                </div>

                <div class="card-body text-center">
                    <h6 class="font-weight-semibold mb-0">Anexo N° {{ $i }}</h6>					    		

                    <div class="list-icons list-icons-extended ">
                        <a onclick="eliminarAnexo(this)" data-id="{{ $anexo->id }}" class="list-icons-item text-danger" data-popup="tooltip" title="Eliminar Anexo" data-container="body">
                            <i class="icon-bin"></i>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>                    
        @endforeach
    </div>
    
@else
    <div class="alert alert-danger" role="alert">
        No existen imagenes
    </div>
@endif
<script>
//funcion para eliminar los anexos ya registrados
function eliminarAnexo(arg) {
     
    swal({
        title: "¿Estás seguro?",
        text: "Que desea eliminar este anexo !",
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
        $.post( "{{ route('eliminar-anexos-formulario') }}", { anexo: $(arg).data('id') })
        .done(function( data ) {
            if(data.success){                    
                notificar("info",data.success);
                cargarAnexos();
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

