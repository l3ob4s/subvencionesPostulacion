<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipoinstitucion extends Model
{
    use HasFactory;

    protected $primaryKey = 'idTipoTipoInstitucion';

    protected $fillable = [
         'codTipoInstitucion', 'descripcionTipoInstitucion'
    ];
}
