<?php
namespace App\Http\Controllers;
use App\Perfil;
use Illuminate\Http\Request;

class Perfil_controller extends Controller
{
    public function createprofile(Request $request)
    {
        $profile = new Perfil($request->all());
            $validate = \Validator::make($request->all(),[
                'codigo_usuario_perfil' => 'required|unique:PERFIL',
                'nombre' => 'required|alpha',
                'apellido1' => 'required|alpha',
                'apellido2' => 'required|alpha',
                'edad' => 'required',
                'sexo' => 'required|alpha',
                'descripcion' => 'alpha',
            ]);
    
            if ($validate->fails() || !is_object($profile)) {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Error al registrar el perfil',
                    'error' => $validate->errors()
                );

            } else {
                \DB::insert(
                    "INSERT INTO PERFIL (codigo_usuario_perfil, nombre, apellido1, apellido2, sexo, edad,descripcion) VALUES (?,?,?,?,?,?,?)",
                    [$profile->codigo_usuario_perfil, $profile->nombre,
                    $profile->apellido1,$profile->apellido2,$profile->sexo, $profile->edad,$profile->descripcion]
                );
                $data = array(
                    'status' => 'correct',
                    'code' => 200,
                    'message' => 'El perfil se ha creado correctamente'
                );

            }

        return response()->json($data, $data['code']);
    }
}
