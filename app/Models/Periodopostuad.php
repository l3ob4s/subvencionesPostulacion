<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodopostuad extends Model
{
    use HasFactory;    

    protected $primaryKey = 'idPeriodopostuad';

    protected $fillable = [
        'numPeriodo','fechaInicioPostu','fechaFinPostu'
    ];
}
