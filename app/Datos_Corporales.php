<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datos_Corporales extends Model
{
    public $timestamps = false;
    protected $table = 'DATOS_CORPORALES';
    protected $fillable = ['peso','altura','indice_grasa', 'indice_MasaMuscular', 'codigo_cliente', 'fecha'];
}

