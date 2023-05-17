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
        Schema::create('tbl_usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('fotop');
            $table->string('direccion');
            $table->unsignedBigInteger('rol_id');
            $table->timestamps();

            $table->foreign('rol_id', 'fk_users_rol_id_tbl_rol')->references('id_rol')
                ->on('tbl_rol')
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
        Schema::dropIfExists('tbl_usuario');
    }
};
