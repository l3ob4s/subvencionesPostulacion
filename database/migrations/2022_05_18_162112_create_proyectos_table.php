<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->increments('idProyecto'); 
            $table->string('codProyecto')->unique()->nullable();
            $table->string('nombreProyecto');
            $table->integer('montoProyecto');
            $table->integer('duracionProyecto');           
            $table->string('objetivoProyecto', 300);
            $table->integer('cantBenefHombreProy');
            $table->integer('cantBenefMujerProy');
            $table->string('resumenProyecto', 1500)->nullable();
          //MV 27-08-2025 (+)
            $table->string('descripProyectoPreg1')->nullable();
            $table->string('descripProyectoPreg2')->nullable();
            $table->string('descripProyectoPreg3')->nullable();
            $table->string('descripTipoTerritorioOtro')->nullable();
            $table->string('descripTipoDifusionOtro')->nullable();
            $table->string('descripTipoMedioVerificacionOtro')->nullable();
          //MV 27-08-2025 (-)
            $table->string('descripNecesidadACubrir', 1000);
            $table->string('descripTerritorioBenef', 1000);
            $table->string('descripDifusionProy', 1000);
            $table->string('descripResultadoProy', 2000);
            $table->string('descripMedioVerifPostEjecuProy', 2000);
            $table->integer('idOrganizacionProyecto');
            $table->integer('idDocumentoProyecto')->nullable();
            $table->integer('idProvinciaProyecto');
            $table->integer('idComunaProyecto');
            $table->integer('idFondoConcursableProyecto');
            $table->integer('idTipoProyecto');
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
        Schema::dropIfExists('proyectos');
    }
}
