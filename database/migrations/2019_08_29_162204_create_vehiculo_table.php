<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->string('placa')->unique();
            $table->string('codigo',255);
            $table->string('marca',255);
            $table->string('modelo',255);
             $table->string('cilindraje',255);
             $table->integer('anio');
             $table->string('motor')->unique();
             $table->enum('estado', ['Disponible', 'Ejecución','Mantenimiento','Dado de baja']);
             $table->string('detalle',255)->nullable();
               $table->unsignedBigInteger('estacion_id');
            $table->foreign('estacion_id')->references('id')->on('estacion');
              $table->unsignedBigInteger('tipoVehiculo_id');
            $table->foreign('tipoVehiculo_id')->references('id')->on('tipoVehiculo');
            $table->timestamps();
            
            $table->bigInteger('creadoPor')->nullable();
            $table->bigInteger('actualizadoPor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculo');
    }
}
