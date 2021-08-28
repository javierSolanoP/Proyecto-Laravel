<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_detalles', function (Blueprint $table) {
            $table->id('id_orden_d');
            $table->unsignedBigInteger('orden_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->double('precio');
            $table->dateTime('fecha');
            $table->foreign('orden_id')->references('id_orden')->on('ordens');
            $table->foreign('producto_id')->references('id_producto')->on('productos');
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
        Schema::dropIfExists('orden_detalles');
    }
}
