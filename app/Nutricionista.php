<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Nutricionista extends Model
{
    public $timestamps = false;
    protected $table = 'NUTRICIONISTA';
    public function client(){
        return $this->belongsTo('App\Usuario');

    }
}
