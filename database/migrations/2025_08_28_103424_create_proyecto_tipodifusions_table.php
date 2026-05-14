<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoTipodifusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('proyecto_tipodifusions')) 
        Schema::create('proyecto_tipodifusions', function (Blueprint $table) {
            $table->id();
            $table->integer('idProyectoFK');
            $table->integer('codTipoDifusion');
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
        Schema::dropIfExists('proyecto_tipodifusions');
    }
}
