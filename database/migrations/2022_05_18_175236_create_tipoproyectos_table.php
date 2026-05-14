<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoproyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoproyectos', function (Blueprint $table) {
            $table->increments('idTipoProyecto'); 
            $table->string('descripcionTipoProyecto');
            $table->integer('idFondoConcursable');            
            $table->boolean('flgProyectoVisible')->nullable();
            $table->integer('duracionMinMeses'); 
            $table->integer('duracionMaxMeses');
            $table->integer('montoMinimo'); 
            $table->integer('montoMaximo');
            $table->integer('codTipoAlcance')->nullable();
            $table->integer('porcEquipamiento')->nullable();
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
        Schema::dropIfExists('tipoproyectos');
    }
}
