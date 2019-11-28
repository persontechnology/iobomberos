<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtencionPrehospitalariasTable extends Migration
{
    /**
     * 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atencion_prehospitalarias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numero');
            $table->string('ambulancia');
            $table->string('nombres');
            $table->string('cedula');
            $table->integer('edad');
            $table->enum('sexo',['Hombre','Mujer'])->nullable();
            $table->time('horaAtencion');
            $table->string('placa')->nullable();
            $table->text('diagnostico');
            $table->integer('pulso');
            $table->integer('temperatura');
            $table->string('presion');
            $table->integer('sp');
            $table->integer('glasgow');
            $table->enum('reaccionDerecha',['RN','RL','RR'])->nullable();
            $table->enum('dilatacionDerecha',['DN','DD','DA'])->nullable();
            $table->enum('reaccionIzquierda',['RN1','RL1','RR1'])->nullable();
            $table->enum('dilatacionIzquierda',['DN1','DD1','DA1'])->nullable();

            $table->unsignedBigInteger('formularioEmergencia_id');            
            $table->foreign('formularioEmergencia_id')->references('id')->on('formularioEmergencia');
            
            
            $table->unsignedBigInteger('clinica_id');            
            $table->foreign('clinica_id')->references('id')->on('clinica');
            $table->string('resposableRecibe');
            $table->time('horaEntrada');

            $table->enum('tipoTransporte',['Transporte Innecesario','Tratamiento Rehusado','Transporte Rehusado'])->nullable();
            $table->string('motivo')->nullable();
            $table->string('nombresDescargo')->nullable();
            $table->string('cedulaDescargo')->nullable();

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
        Schema::dropIfExists('atencion_prehospitalarias');
    }
}
