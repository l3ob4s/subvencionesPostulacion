<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodopostuadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('periodopostuads')) 
        Schema::create('periodopostuads', function (Blueprint $table) {
            $table->increments('idPeriodopostuad');
            $table->integer('numPeriodo');
            $table->datetime('fechaInicioPostu');
            $table->datetime('fechaFinPostu'); 
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
        Schema::dropIfExists('periodopostuads');
    }
}
