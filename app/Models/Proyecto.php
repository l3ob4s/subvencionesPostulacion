<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $primaryKey = 'idProyecto';

    protected $fillable = [
        'codProyecto', 'nombreProyecto', 'montoProyecto', 'duracionProyecto', 'objetivoProyecto', 
        'cantBenefHombreProy', 'cantBenefMujerProy', 'resumenProyecto', 
        'descripNecesidadACubrir', 'descripTerritorioBenef',  'descripDifusionProy',
        'descripResultadoProy', 'descripMedioVerifPostEjecuProy', 'idOrganizacionProyecto', 'idDocumentoProyecto', 
        'idFondoConcursableProyecto', 'idTipoProyecto', 'idProvinciaProyecto', 'idComunaProyecto',
        //28-08-2025 MV 
           'descripProyectoPreg1' , 'descripProyectoPreg2', 'descripProyectoPreg3', 'descripTipoDifusionOtro','descripTipoTerritorioOtro', 'descripTipoMedioVerificacionOtro',
    ];                  
}
