<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',255)->nullable();
            $table->string('direccion',255)->nullable();
            $table->string('latitud',255)->nullable();
            $table->string('longitud',255)->nullable();
             $table->string('foto')->nullable();
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
        Schema::dropIfExists('estacion');
    }
}
