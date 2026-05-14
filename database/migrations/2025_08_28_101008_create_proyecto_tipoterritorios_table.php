<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoTipoterritoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('proyecto_tipoterritorios')) 
        Schema::create('proyecto_tipoterritorios', function (Blueprint $table) {
            $table->id();
            $table->integer('idProyectoFK');
            $table->integer('codTipoTerritorio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto_tipoterritorios');
    }
}
