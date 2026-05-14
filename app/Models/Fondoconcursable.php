<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fondoconcursable extends Model
{
    use HasFactory;

    protected $primaryKey = 'idFondoConcursable';
    
    protected $fillable = [
        'codigoFondoConcursable', 'descripcionFondoConcursable', 'montoMinFondo', 'montoMaxFondo', 'duracionMinMeses', 'duracionMaxMeses', 
        'idEstadoFondoConcursable', 'idTipologiaProyecto', 'flgVisible', 'codTipoAlcance', 'porcEquipamiento'
    ]; 
}
