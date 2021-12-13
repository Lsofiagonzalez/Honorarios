<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmodulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submodulos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 20);
            $table->text('descripcion');
            $table->tinyInteger('estado')->default(1);
            $table->string('icono', 20);
            $table->tinyInteger('visible')->default(1);
            $table->integer('modulo_id');
            $table->timestamps();

            $table->foreign('modulo_id')->references('id')->on('modulos');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submodulos');
    }
}
