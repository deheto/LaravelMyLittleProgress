<?php
namespace App\Http\Controllers;
use App\Usuario;
use Illuminate\Http\Request;
use mysqli;
use PharIo\Manifest\Email;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class User_controller extends Controller
{
    public function register(Request $request)
    {
        $user = new Usuario($request->all());
        
        $user->tipo = 'Cliente';

            $validate = Validator::make($request->all(),[
                'correo' => 'required|email|unique:USUARIO',
                'contrasena' => 'required'
            ]);

            if ($validate->fails() || !is_object($user)) {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'El correo ya está registrado',
                    'error' => $validate->errors()
                );
                
            } else {
                $pwd = hash('sha256', $user->contrasena);
                DB::insert(
                    "INSERT INTO USUARIO (correo, contrasena, tipo) VALUES (?,?,?)",
                    [$user->correo, $pwd, $user->tipo]
                );

                $results = \DB::select("SELECT codigo, correo, tipo FROM USUARIO WHERE correo = '$user->correo' AND
                contrasena = '$pwd'");


                $data = array(
                    'status' => 'register_success',
                    'code' => 200,
                    'message' => 'El usuario se ha creado correctamente',
                    'body' => $results,
                );
            }
        return response()->json($data, $data['code']);
    }

    public function login(Request $request)
    {
        $user = new Usuario($request->all());
      
        $validate = Validator::make($request->all(), [

            'correo' => 'required|email',
            'contrasena' => 'required'
        ]);

       if ($validate->fails() || !is_object($user) ) {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'No se ha podido logear',
                    'error' => $validate->errors()
                );
            } else {

                $pwd = hash('sha256', $user->contrasena);

               

                $results = \DB::select("SELECT * FROM USUARIO WHERE correo = 
                '$user->correo' AND contrasena ='$pwd'");
        
              
                var_dump($results);
        
                     if (count($results) > 0 ) {
             
                        $data = array(
                        'status' => 'login_success',
                        'code' => 200,
                        'message' => 'El usuario se ha logeado correctamente',
                        'body' =>  $results
                    );

                } else {
                    $data = array(
                        'status' => 'error',
                        'code' => 404,
                        'message' => 'La contraseña o el correo no coiciden'
                    );
                 }
                }

        return response()->json($data, $data['code']);
    }
}
