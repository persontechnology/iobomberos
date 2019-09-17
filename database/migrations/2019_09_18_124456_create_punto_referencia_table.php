<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntoReferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntoReferencia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('latitud',255);
            $table->string('longitud',255);
            $table->string('referencia',255);
            $table->unsignedBigInteger('barrio_id');
            $table->foreign('barrio_id')->references('id')->on('barrios');
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
        Schema::dropIfExists('puntoReferencia');
    }
}
