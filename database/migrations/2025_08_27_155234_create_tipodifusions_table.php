<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipodifusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('tipodifusions')) 
        Schema::create('tipodifusions', function (Blueprint $table) {
            $table->increments('idTipoDifusion'); 
            $table->integer('codTipoDifusion'); 
            $table->string('descripcionTipoDifusion');
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
        Schema::dropIfExists('tipodifusions');
    }
}
