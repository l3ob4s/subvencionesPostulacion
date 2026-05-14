<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rrhhproyecto extends Model
{
    use HasFactory;

    protected $primaryKey = 'idRRHHProyecto';

    protected $fillable = [
        'descripCargo',
        'descripFuncActividades',
        'descripPerfilCargo',
        'totalHorasServicio',
        'descripPeriocidadServicio',
        'montoTotalServicio',
        'idProyecto',
    ];
}
