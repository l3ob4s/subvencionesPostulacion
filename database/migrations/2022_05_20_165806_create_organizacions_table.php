<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizacions', function (Blueprint $table) {
            $table->increments('idOrganizacion');
            $table->unsignedInteger('runOrganizacion');
            $table->char('dvRunOrganizacion', 1);
            $table->string('nombreOrganizacion');
            $table->unsignedSmallInteger('agnosExistencia');
            $table->unsignedSmallInteger('codTipoVia');
            $table->string('direccionOrganizacion')->nullable();
            $table->string('nombreVia', 150)->nullable();
            $table->unsignedSmallInteger('numDireccion');
            $table->string('telefonoOrganizacion');
            $table->string('correoOrganizacion');
            $table->date('fecVencDirectiva');
            $table->integer('idProvinciaOrg');
            $table->integer('idComunaOrg');
            $table->integer('idRepLegal');
            $table->integer('idBanco');
            $table->integer('idTipocuenta');
            $table->string('numeroCuenta');
            $table->integer('codTipoInstitucion')->nullable(); //MV 28-08-2025 Faridi
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
        Schema::dropIfExists('organizacions');
    }
}
