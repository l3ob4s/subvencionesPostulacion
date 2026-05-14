<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoterritoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (!Schema::hasTable('tipoterritorios')) 
        Schema::create('tipoterritorios', function (Blueprint $table) {
            $table->increments('idTipoTerritorio'); 
             $table->integer('codTipoTerritorio'); 
            $table->string('descripcionTipoTerritorio');
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
        Schema::dropIfExists('tipoterritorios');
    }
}
