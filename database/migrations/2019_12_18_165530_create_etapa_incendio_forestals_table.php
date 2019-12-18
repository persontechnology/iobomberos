<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtapaIncendioForestalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapa_incendio_forestals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('iniciacion')->default(false);
            $table->boolean('propagacion')->default(false);
            $table->boolean('estabilizado')->default(false);
            $table->boolean('activo')->default(false);           
            $table->boolean('controlado')->default(false);
            $table->boolean('extinguido')->default(false); 
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
        Schema::dropIfExists('etapa_incendio_forestals');
    }
}
