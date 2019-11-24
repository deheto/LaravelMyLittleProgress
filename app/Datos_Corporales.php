<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datos_Corporales extends Model
{
    public $timestamps = false;
 
    protected $table = 'DATOS_CORPORALES';

    public function client(){
        return $this->belongsTo('App\Cliente', 'codigo_cliente');

    }

}
