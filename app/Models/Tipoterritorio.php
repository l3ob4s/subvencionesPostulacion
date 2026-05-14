<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipoterritorio extends Model
{
    use HasFactory;

    protected $primaryKey = 'idTipoTerritorio';

    protected $fillable = [
         'codTipoTerritorio', 'descripcionTipoTerritorio'
    ]; 
}
