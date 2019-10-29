<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtapaIncendiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapa_incendios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('incipiente')->default(false);
            $table->boolean('desarrollo')->default(false);
            $table->boolean('combustion')->default(false);
            $table->boolean('flashover')->default(false);
            $table->boolean('decadencia')->default(false);
            $table->boolean('arder')->default(false);
            
            $table->unsignedBigInteger('formularioEmergencia_id');            
            $table->foreign('formularioEmergencia_id')->references('id')->on('formularioEmergencia');
            
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
        Schema::dropIfExists('etapa_incendios');
    }
}
