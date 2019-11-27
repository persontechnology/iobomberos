@extends('layouts.app',['title'=>'Nuevo Atención'])

@section('content')
<div class="card">
    <div class="card-header text-center">
        Nuevo registro de atención Pre-Hospitalaria del formulario N° <strong> {{$formulario->numero}} </strong>
    </div>
    <div class="card-body">
        <form action="" method="POST" >
            @csrf
                <input type="hidden" value="{{$formulario->id}}">
                <div class="form-group">
                    <label for="exampleInputEmail1">N° Ambulancia</label>
                    <input type="text" class="form-control" id="ambulancia" name="ambulancia" >                    
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr class="text-center bg-dark">
                            <th colspan="5">
                                <strong>  Datos Generales </strong>
                            </th>
                        </tr>
                        <tr>
                            <th  colspan="2"><strong>Nombres</strong><input type="text" name="nombres" class="form-control"></th>
                            <th><strong>Cédula</strong><input type="text" name="cedula" class="form-control"></th>
                            <th><strong>Edad</strong><input type="text" name="edad" class="form-control"></th>
                            <th><strong>Sexo</strong><input type="text" name="sexo" class="form-control"></th>
                        </tr>
                        <tr>
                            <th><strong>Hora</strong><input type="time" name="hora" class="form-control"></th>
                            <th><strong>Dirección Evento : </strong> <br>{{$formulario->puntoReferencia->referencia}}</th>
                            <th><strong>Punto Referencia : </strong> <br>{{$formulario->puntoReferencia->referencia}}</th>
                            <th><strong>Fecha Atención : </strong> <br>{{$formulario->fecha}}</th>
                            <th><strong>Número Placa</strong><input type="text" name="placa" class="form-control"></th>

                        </tr>

                    </table>
                </div>
                <br>
                <p class="bg-dark text-center p-2"> <strong>Examen Físico y Diagnóstico</strong></p>
                <div class="form-group">
                    <label for="exampleInputEmail1">Diagnóstico Presuntivo</label>                    
                    <textarea class="form-control" id="diagnostico" name="diagnostico"></textarea>                    
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr class="text-center bg-dark">
                            <th colspan="5">
                                <strong>Signos vitales</strong>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <div class="form-group" class="text-center">
                                    <label for="">Pulso</label>
                                    <input type="number" id="pulso" name="pulso" value="" class="form-control">
                                </div>
                            </th>
                            <th>
                                <div class="form-group" class="text-center">
                                    <label for="">Temperatura</label>
                                    <input type="number" id="temperatura" name="temperatura" value="" class="form-control">
                                </div>
                            </th>
                            <th>
                                <div class="form-group" class="text-center">
                                    <label for="">Presión Arterial</label>
                                    <input type="text" id="" name="presion"  class="form-control">
                                </div>
                            </th>
                            <th>
                                <div class="form-group" class="text-center">
                                    <label for="">SP02%</label>
                                    <input type="number" id="sp" name="sp" value="" class="form-control">
                                </div>
                            </th>
                            <th>
                                <div class="form-group" class="text-center">
                                    <label for="glasgow">Total Glasgow (15) </label>
                                    <input type="number" id="glasgow" name="glasgow" value="" class="form-control">
                                </div>
                            </th>
                            
                        </tr>
                        <tr>
                            <th>
                                <div class="form-group" class="text-center">
                                    <label for="reaccionDerecha">Reacción (RN-RL-RR)</label>
                                    <input type="text" id="reaccionDerecha" name="reaccionDerecha" value="" class="form-control">
                                </div>
                            </th>
                            <th>
                                <div class="form-group" class="text-center">
                                    <label for="dilatacionDerecha">Dilatación (DN-DD-DA)</label>
                                    <input type="text" id="dilatacionDerecha" name="dilatacionDerecha" value="" class="form-control">
                                </div>
                            </th>
                            <th>
                                <div class="form-group" class="text-center">
                                    <label for="reaccionIzquierda">Reacción (RN-RL-RR)</label>
                                    <input type="text" id="reaccionIzquierda" name="reaccionIzquierda" value="" class="form-control">
                                </div>
                            </th>
                            <th>
                                <div class="form-group" class="text-center">
                                    <label for="dilatacionIzquierda">Dilatación (DN-DD-DA)</label>
                                    <input type="text" id="dilatacionIzquierda" name="dilatacionIzquierda" value="" class="form-control">
                                </div>
                            </th>
                        </tr>
                    </table>
                </div>
                <p class="bg-dark text-center p-2"> <strong>Condición de llegada al hospital</strong></p>

                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group" class="text-center">
                        <label for="clinica">Selecione un establecimiento que recibe</label>
                        @if ($clinicas->count()>0)                        
                        <select class="form-control" name="clinica" id="clinica">
                            @foreach ($clinicas as $clinica)
                            <option value="{{$clinica->id}}">{{$clinica->nombre}}</option>                            
                            @endforeach
                        </select>
                        @else
                            <div class="alert alert-danger" role="alert">
                                No existe clinicas
                            </div>
                        @endif
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group" class="text-center">
                            <label for="resposableRecibe">Responsable que recibe</label>
                            <input type="text" id="resposableRecibe" name="resposableRecibe" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group" class="text-center">
                            <label for="horaEntrada">Hora de entrada</label>
                            <input type="time" id="horaEntrada" name="horaEntrada" value="" class="form-control">
                        </div>
                    </div>

                </div>
                <p class="bg-dark text-center p-2"> <strong>Descargo de medicamentos e insumos</strong></p>
                @if ($insumos->count()>0)
                    <div class="row"> 
                        @foreach ($insumos as $insumo)
                            <div class="col-sm-4">
                                <p class="text-center p-2"> <strong>{{$insumo->nombre}}</strong></p>
                                <ul>
                                    
                                    @foreach ($insumo->medicamentos as $medicamentos)
                                
                                        <div class="form-group">

                                            {{$medicamentos->nombre}}
                                    
                                   
                                        <input type="number" class="form-control"> 
                                        </div>
                                            
                                            
                                            
                                      
                                        @endforeach
                                   
                                </ul>
                            </div>                            
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        No existen insumos 
                    </div>
                @endif

        </form>
     
    </div>
</div>
@endsection