<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuariosAPP', function (Blueprint $table) {
            //id, nombre_usuario, estado, rol_id, GD_id
            $table->increments('id');
            $table->string('nombre_usuario', 20)->unique();
            $table->string('password');
            $table->tinyInteger('estado')->default(1);
            $table->integer('rol_id');
            $table->integer('GD_id');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('roles');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
