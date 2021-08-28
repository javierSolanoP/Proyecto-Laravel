<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->id('id_carrito');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('producto_id')->references('id_producto')->on('productos');
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios');
            $table->integer('cantidad');
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
        Schema::dropIfExists('carritos');
    }
}
