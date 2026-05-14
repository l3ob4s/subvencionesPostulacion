<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestoeqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestoeqs', function (Blueprint $table) {
            $table->increments('idPptoEq'); 
            $table->integer('idProyecto');
            $table->string('detaequipo');
            $table->integer('idActividad');
            $table->integer('cantidad');
            $table->integer('montototal');
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
        Schema::dropIfExists('presupuestoeqs');
    }
}
