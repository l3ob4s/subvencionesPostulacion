<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuestorh extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPptoRRHH';

    protected $fillable = [
        'idProyecto', 'perfil', 'idActividad', 'canthora', 'valorhora', 'montototal'
    ];
}
