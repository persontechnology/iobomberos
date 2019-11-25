<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormularioEstacionVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_estacion_vehiculos', function (Blueprint $table) {
            $table->bigIncrements('id');
       
            $table->unsignedBigInteger('estacionForEmergencias_id');            
            $table->foreign('estacionForEmergencias_id')->references('id')->on('estacion_formulario_emergencias');

            $table->unsignedBigInteger('asistenciaVehiculo_id');            
            $table->foreign('asistenciaVehiculo_id')->references('id')->on('asistencia_vehiculos');
            $table->bigInteger('creadoPor')->nullable();
            $table->bigInteger('actualizadoPor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formulario_estacion_vehiculos');
    }
}
