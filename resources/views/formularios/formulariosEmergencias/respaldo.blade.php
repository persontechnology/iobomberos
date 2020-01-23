
@if ($formulario->foto)
<img src="{{ $formulario->foto }}"   class="img-fluid img-thumbnail"/>
@else
    <div class="alert alert-danger" role="alert">
      Actualice la imagen para el reporte
    </div>
@endif
<script>
    
  $("#geeks").click(function() { 
    
    html2canvas($("#map"), { 
        useCORS: true,
        onrendered: function(canvas) {             
            var dataURL = canvas.toDataURL();
         
            $.post( "{{ route('formulario-imagen') }}", { formulario: "{{ $formulario->id }}",foto:dataURL })
                .done(function( data ) {
               
                }).always(function(){
                    $.unblockUI();
                }).fail(function(){
                    notificar("error","Ocurrio un error");
                });         
            
        } 
    }); 
}); 
</script>