<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_factura_producto', function (Blueprint $table) {
            $table->id('id_factura_producto');
            $table->integer('total_producto');
            $table->integer('cantidad');
            $table->integer('tendero_id');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('factura_id');
            $table->string('estado');

            $table->foreign('producto_id', 'fk_tbl_factura_producto_producto_id_tbl_producto')->references('id_producto')
                ->on('tbl_producto')
                ->onDelete('cascade');

            $table->foreign('factura_id', 'fk_tbl_factura_producto_factura_id_tbl_producto')->references('id_factura')
                ->on('tbl_factura')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_factura_producto');
    }
};
