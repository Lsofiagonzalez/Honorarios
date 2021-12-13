<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('valor', 50);
            $table->string('abreviacion', 10);
            $table->string('nombre', 50);
            $table->integer('parametro_tabla_id');
            $table->timestamps();

            $table->foreign('parametro_tabla_id')->references('id')->on('parametro_tablas');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parametros');
    }
}
