<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public $timestamps = false;
    // protected $table = 'USUARIO';
    protected $fillable = ['correo','tipo','contrasena'];
   
}
