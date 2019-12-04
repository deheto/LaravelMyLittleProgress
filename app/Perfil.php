<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    public $timestamps = false;
    protected $table = 'PERFIL';
    protected $fillable = ['codigo_usuario_perfil','nombre','apellido1', 'apellido2', 'edad', 'sexo', 'descripcion'];
}
