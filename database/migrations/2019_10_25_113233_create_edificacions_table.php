<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edificacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('madera')->default(false);
            $table->boolean('hormigon')->default(false);
            $table->boolean('mixta')->default(false);
            $table->boolean('metalica')->default(false);
            $table->boolean('adobe')->default(false);
            $table->boolean('plantaBaja')->default(false);
            $table->boolean('primerPiso')->default(false);
            $table->boolean('segundoPiso')->default(false);
            $table->boolean('tercerPiso')->default(false);
            $table->boolean('patio')->default(false);
            
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
        Schema::dropIfExists('edificacions');
    }
}
