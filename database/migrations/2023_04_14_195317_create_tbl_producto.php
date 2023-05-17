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
        Schema::create('tbl_producto', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombrep', 50);
            $table->integer('precio');
            $table->string('peso_neto',40);
            $table->integer('stock');
            $table->string('foto');
            $table->string('estado');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();

            $table->foreign('usuario_id', 'fk_tbl_producto_usuario_id_users')->references('id_usuario')
                ->on('tbl_usuario')
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
        Schema::dropIfExists('tbl_producto');
    }
};
