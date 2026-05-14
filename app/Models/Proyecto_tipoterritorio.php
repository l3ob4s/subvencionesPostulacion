<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto_tipoterritorio extends Model
{
    use HasFactory;

    protected $fillable = [
        'idProyectoFK', 'codTipoTerritorio'
    ];               
}
