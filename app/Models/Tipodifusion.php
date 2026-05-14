<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipodifusion extends Model
{
    use HasFactory;

    protected $primaryKey = 'idTipoDifusion';

    protected $fillable = [
         'codTipoDifusion', 'descripcionTipoDifusion'
    ]; 
}
