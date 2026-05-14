<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestorhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestorhs', function (Blueprint $table) {
            $table->increments('idPptoRRHH'); 
            $table->string('perfil');
            $table->integer('idActividad');
            $table->integer('idProyecto');
            $table->integer('canthora');
            $table->integer('valorhora');
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
        Schema::dropIfExists('presupuestorhs');
    }
}
