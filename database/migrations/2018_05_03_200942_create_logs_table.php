<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            //id, tabla_id, nombre_tabla, accion, responsable_id
            $table->increments('id');
            $table->integer('registro_id');
            $table->string('nombre_tabla', 50);
            $table->string('accion', 50);
            $table->integer('responsable_id');
            $table->timestamps();

            $table->foreign('responsable_id')->references('id')->on('usuariosAPP');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
