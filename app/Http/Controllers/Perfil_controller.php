<?php
namespace App\Http\Controllers;
use App\Perfil;
use Illuminate\Http\Request;

class Perfil_controller extends Controller
{
    public function createprofile(Request $request)
    {

        //CORREGIR LA HORA DE AGARRAR LOS DATOS DEL SEXO, DEBERIA VERIFICAR SI ES F O M.
        $profile = new Perfil($request->all());
           
        $validate = \Validator::make($request->all(),[
                'codigo_usuario_perfil' => 'required|unique:PERFIL',
                'nombre' => 'required|alpha',
                'apellido1' => 'required|alpha',
                'apellido2' => 'required|alpha',
                'edad' => 'required|numeric',
                'sexo' => 'required|alpha'
            ]);

            $user = \DB::table('USUARIO')->where('codigo',$profile->codigo_usuario_perfil)->first();
  
            
            if ($validate->fails() || !is_object($profile)) {

                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'PROFILE_ALREADY_EXISTS',
                    'error' => $validate->errors()
                );


            } else if ( !is_object($user) ){


                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'USER_DOES_NOT_EXISTS',
                    'error' => $validate->errors()
                );


            }else {
        

                \DB::insert(
                    "INSERT INTO PERFIL (codigo_usuario_perfil, nombre, apellido1, apellido2, sexo, edad,descripcion) VALUES (?,?,?,?,?,?,?)",
                    [$profile->codigo_usuario_perfil, $profile->nombre,
                    $profile->apellido1,$profile->apellido2,$profile->sexo, $profile->edad,$profile->descripcion]
                );

                $user = \DB::table('PERFIL')->where('codigo_usuario_perfil',$profile->codigo_usuario_perfil)->first();
  

                $data = array(
                    'status' => 'correct',
                    'code' => 200,
                    'message' => 'SUCCESS',
                    'body' =>  $user
                );

            }

        return response()->json($data, $data['code']);
    }
}
