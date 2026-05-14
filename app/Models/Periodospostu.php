<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodospostu extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPeriodopostu';

    protected $fillable = [
        'numPeriodo','fechaInicioPostu','fechaFinPostu'
    ];
}
