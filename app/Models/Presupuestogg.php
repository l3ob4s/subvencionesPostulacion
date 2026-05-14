<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuestogg extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPptoGG';

    protected $fillable = [
        'idProyecto', 'detabienesservicio', 'idActividad', 'descripcion', 'montototal'
    ];
}
