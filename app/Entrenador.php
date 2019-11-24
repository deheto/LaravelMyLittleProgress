<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrenador extends Model
{

    public $timestamps = false;
 
    protected $table = 'ENTRENADOR';

    public function client(){
        return $this->belongsTo('App\Cliente');

    }

}
