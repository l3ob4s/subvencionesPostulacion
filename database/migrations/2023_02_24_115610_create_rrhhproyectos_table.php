<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRrhhproyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrhhproyectos', function (Blueprint $table) {
            $table->increments('idRRHHProyecto'); 
            $table->string('descripCargo', 150);
            $table->string('descripFuncActividades', 150);
            $table->string('descripPerfilCargo', 150);
            $table->integer('totalHorasServicio');
            $table->string('descripPeriocidadServicio', 150);
            $table->integer('montoTotalServicio');
            $table->integer('idProyecto');
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
        Schema::dropIfExists('rrhhproyectos');
    }
}
