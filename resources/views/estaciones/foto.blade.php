@if (Storage::exists($est->foto))
    <a href="{{ Storage::url($est->foto) }}" class="btn-link" data-toggle="tooltip" data-placement="top" title="Ver foto">
        <img src="{{ Storage::url($est->foto) }}" alt="" class="img-fluid" width="45px;">
    </a>
@else
    <img src="{{ asset('img/estacion.png') }}" alt="" class="img-fluid" width="45px;">
@endif