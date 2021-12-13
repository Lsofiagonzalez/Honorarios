<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 20);
            $table->text('descripcion');
            $table->tinyInteger('estado')->default(1);
            $table->integer('rol_id')->nullable();
            $table->timestamps();
        });

        if (Schema::hasTable('roles')){
            Schema::table('roles', function (Blueprint $table) {
                $table->foreign('rol_id')->references('id')->on('roles');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
