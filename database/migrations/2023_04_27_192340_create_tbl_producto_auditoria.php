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
        Schema::create('tbl_producto_auditoria', function (Blueprint $table) {
            $table->bigIncrements('id_producto_Auditoria');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('accion');
            $table->integer('precio');
            $table->timestamps();
            //      //
            $table->foreign('producto_id')->references('id_producto')
                ->on('tbl_producto')
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
        Schema::dropIfExists('tbl_producto_auditoria');
    }
};
