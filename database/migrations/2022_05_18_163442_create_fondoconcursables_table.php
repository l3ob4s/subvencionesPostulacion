<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFondoconcursablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('fondoconcursables')) 
        Schema::create('fondoconcursables', function (Blueprint $table) {
            $table->increments('idFondoConcursable'); 
            $table->char('codigoFondoConcursable', 2)->unique();
            $table->string('descripcionFondoConcursable');
            $table->integer('duracionMinMeses'); 
            $table->integer('duracionMaxMeses');
            $table->integer('montoMinFondo');
            $table->integer('montoMaxFondo');
            $table->integer('idEstadoFondoConcursable');
            $table->integer('idTipologiaProyecto');
            $table->boolean('flgVisible')->nullable();
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
        Schema::dropIfExists('fondoconcursables');
    }
}
