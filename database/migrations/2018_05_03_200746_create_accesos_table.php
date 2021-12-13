<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 20);
            $table->text('descripcion');
            $table->tinyInteger('estado')->default(1);
            $table->integer('submodulo_id');
            $table->string('controlador', 100);
            $table->string('ruta_nombre', 100);
            $table->tinyInteger('visible')->default(1);
            $table->timestamps();

            $table->foreign('submodulo_id')->references('id')->on('submodulos');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accesos');
    }
}
