<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestoggsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestoggs', function (Blueprint $table) {
            $table->increments('idPptoGG'); 
            $table->integer('idProyecto');
            $table->string('detabienesservicio');
            $table->integer('idActividad');            
            $table->string('descripcion');
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
        Schema::dropIfExists('presupuestoggs');
    }
}
