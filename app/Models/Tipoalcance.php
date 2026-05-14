<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipoalcance extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'idTipoAlcance';

    protected $fillable = [
         'codTipoAlcance', 'descripcionTipoAlcance',
    ]; 

}
