<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objetivosespecifico extends Model
{
    use HasFactory;

    protected $primaryKey = 'idObjEspecifico';

    protected $fillable = [
        'descripcionObjEspecifico', 'idProyecto'
    ];
}
