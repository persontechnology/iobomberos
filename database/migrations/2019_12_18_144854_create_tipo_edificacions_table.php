<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoEdificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_edificacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('domestico')->default(false);
            $table->boolean('comercial')->default(false);
            $table->boolean('industrial')->default(false);
            $table->boolean('galpones')->default(false);           
            
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
        Schema::dropIfExists('tipo_edificacions');
    }
}
