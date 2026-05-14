<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipomediosverificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tipomediosverificacions')) 
        Schema::create('tipomediosverificacions', function (Blueprint $table) {
            $table->increments('idTipoMedioVerificacion'); 
            $table->integer('codTipoMedioVerificacion'); 
            $table->string('descripcionTipoMedioVerificacion');
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
        Schema::dropIfExists('tipomediosverificacions');
    }
}
