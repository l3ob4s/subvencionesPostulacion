<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoinstitucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoinstitucions', function (Blueprint $table) {
            $table->increments('idTipoTipoInstitucion'); 
            $table->integer('codTipoInstitucion'); 
            $table->string('descripcionTipoInstitucion');
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
        Schema::dropIfExists('tipoinstitucions');
    }
}
