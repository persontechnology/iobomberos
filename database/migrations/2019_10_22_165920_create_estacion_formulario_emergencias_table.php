<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstacionFormularioEmergenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estacion_formulario_emergencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedBigInteger('estacion_id');            
            $table->foreign('estacion_id')->references('id')->on('estacion');

            $table->unsignedBigInteger('formularioEmergencia_id');            
            $table->foreign('formularioEmergencia_id')->references('id')->on('formularioEmergencia');

            $table->unsignedBigInteger('user_id')->nullable();            
            $table->foreign('user_id')->references('id')->on('users');

            $table->text('origin_causa_evento')->nullable();
            $table->text('trabajo_realizado')->nullable();
            


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estacion_formulario_emergencias');
    }
}
