<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculoParamedicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo_paramedicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('estacionForVehiculo_id');            
            $table->foreign('estacionForVehiculo_id')->references('id')->on('formulario_estacion_vehiculos');

            $table->unsignedBigInteger('asistenciaPersonal_id');            
            $table->foreign('asistenciaPersonal_id')->references('id')->on('asistencia_personals');
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
        Schema::dropIfExists('vehiculo_paramedicos');
    }
}
