<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoIncendioForestalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_incendio_forestals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('agricola')->default(false);
            $table->boolean('suelo')->default(false);
            $table->boolean('copas')->default(false);
            $table->boolean('subSuelo')->default(false);           
            
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
        Schema::dropIfExists('tipo_incendio_forestals');
    }
}
