<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipomediosverificacion extends Model
{
    use HasFactory;

    protected $primaryKey = 'idTipoMedioVerificacion';

    protected $fillable = [
         'codTipoMedioVerificacion', 'descripcionTipoMedioVerificacion'
    ]; 
}
