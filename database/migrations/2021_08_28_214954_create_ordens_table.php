<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordens', function (Blueprint $table) {
            $table->id('id_orden');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('metodo_id');
            $table->unsignedBigInteger('direccion_id');
            $table->double('total');
            $table->unsignedBigInteger('carrito_id');
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios');
            $table->foreign('metodo_id')->references('id_metodo')->on('metodo_pagos');
            $table->foreign('direccion_id')->references('id_direccion')->on('direccions');
            $table->foreign('carrito_id')->references('id_carrito')->on('carritos');
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
        Schema::dropIfExists('ordens');
    }
}
