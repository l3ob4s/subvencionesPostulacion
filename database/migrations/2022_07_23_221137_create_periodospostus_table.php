<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodospostusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodospostus', function (Blueprint $table) {
            $table->increments('idPeriodopostu');
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
        Schema::dropIfExists('periodospostus');
    }
}
