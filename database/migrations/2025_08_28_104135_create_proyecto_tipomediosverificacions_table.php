<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoTipomediosverificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('proyecto_tipomediosverificacions')) 
        Schema::create('proyecto_tipomediosverificacions', function (Blueprint $table) {
            $table->id();
             $table->integer('idProyectoFK');
            $table->integer('codTipoMedioVerificacion');
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
        Schema::dropIfExists('proyecto_tipomediosverificacions');
    }
}
