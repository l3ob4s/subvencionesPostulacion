<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    use HasFactory;

    protected $primaryKey = 'idRepLegal';

    protected $fillable = [
        'rutRepLegal', 'dvRutRepLegal', 'nomRepLegal', 'telefonoRepLegal', 'correoRepLegal'
    ];
}
