<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre', 100);
            $table->string('descripcion', 180);
            $table->string('marca', 40);
            $table->double('precio');
            $table->integer('cantidad');
            $table->unsignedBigInteger('imagen_prod_id');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('imagen_prod_id')->references('id_prod_img')->on('producto__imagenes');
            $table->foreign('categoria_id')->references('id_categoria')->on('categorias');
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
        Schema::dropIfExists('productos');
    }
}
