<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipoproyecto extends Model
{
    use HasFactory;

    protected $primaryKey = 'idTipoProyecto';

    protected $fillable = [
         'descripcionTipoProyecto', 'idFondoConcursable', 'codTipoInstitucion', 'flgProyectoVisible', 'duracionMinMeses', 
         'duracionMaxMeses','montoMinimo', 'montoMaximo', 'codTipoAlcance', 'porcEquipamiento'
    ]; 

}
