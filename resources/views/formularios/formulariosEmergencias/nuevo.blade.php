@extends('layouts.app',['title'=>'formularios'])

@section('breadcrumbs', Breadcrumbs::render('formularios'))

@section('barraLateral')

@endsection

@section('content')
<div class="card">
       <div class="card-body">
        <form method="POST" action="#" id="formNuevoUsuario" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="emergencia" class="col-md-2 col-form-label text-md-right">{{ __('Emergencia') }}<i class="text-danger">*</i></label>

                <div class="col-md-10">
                    @if($emergencias)
                        <select class="form-control @error('emergencia') is-invalid @enderror" name="emergencia" id="emergencia" >
                            @foreach($emergencias as $esta)
                            <option value="{{ $esta->id }}" {{ (old("emergencia") == $esta->id ? "selected":"") }} >{{$esta->nombre}}</option>
                            @endforeach
                        </select>

                        @error('emergencia_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        @endif
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6">
                   
                    <div class="form-group row">
                        <label for="institucion" class="col-md-4 col-form-label text-md-right">{{ __(' Nombre Institución') }}<i class="text-danger">*</i></label>
    
                        <div class="col-md-6">
                            <input id="institucion" type="text" class="form-control @error('institucion') is-invalid @enderror" name="institucion" value="{{ old('institucion') }}" required autocomplete="institucion" autofocus placeholder="institucion">
    
                            @error('institucion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                  
                    <div class="form-group row">
                            <label for="formaAviso" class="col-md-4 col-form-label text-md-right">{{ __('   Forma de Aviso') }}<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                <input id="formaAviso" type="text" class="form-control @error('formaAviso') is-invalid @enderror" name="formaAviso" value="{{ old('formaAviso') }}" required autocomplete="formaAviso" autofocus placeholder="formaAviso">
        
                                @error('formaAviso')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                </div>
            </div>
        </form>
        
    </div>
</div>

@push('linksCabeza')


@endpush

@prepend('linksPie')
<script type="text/javascript">
    $('#menuGestionFomularios').addClass('nav-item-expanded nav-item-open');
     $('#menuFormularios').addClass('active');
</script>

@endprepend

@endsection