<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizacion extends Model
{
    use HasFactory;

    protected $primaryKey = 'idOrganizacion';

    protected $fillable = [
        'runOrganizacion', 'dvRunOrganizacion', 'nombreOrganizacion', 'codTipoInstitucion', 'agnosExistencia',
        'codTipoVia', 'nombreVia', 'numDireccion', 'direccionOrganizacion', 'telefonoOrganizacion', 'correoOrganizacion',
        'fecVencDirectiva', 'idProvinciaOrg', 'idComunaOrg', 'idRepLegal', 'idBanco', 'idTipocuenta', 'numeroCuenta',
    ];
}
