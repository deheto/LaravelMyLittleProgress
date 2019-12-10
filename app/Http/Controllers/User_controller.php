<?php
namespace App\Http\Controllers;
use App\Usuario;
use Illuminate\Http\Request;
use mysqli;
use PharIo\Manifest\Email;

class User_controller extends Controller
{
    public function register(Request $request)
    {
        $user = new Usuario($request->all());
        
        $user->tipo = 'Cliente';

            $validate = \Validator::make($request->all(),[
                'correo' => 'required|email|unique:USUARIO',
                'contrasena' => 'required'
            ]);

            if ($validate->fails() || !is_object($user)) {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'EMAIL_ALREADY_EXISTS',
                    'error' => $validate->errors()
                );
                
            } else {
                $pwd = hash('sha256', $user->contrasena);
               
                \DB::insert(
                    "INSERT INTO USUARIO (correo, contrasena, tipo, perfil_registrado,datos_corporales_registrado ) VALUES (?,?,?,?,?)",
                    [$user->correo, $pwd, $user->tipo,'0','0']
                );


                $results = \DB::select("SELECT codigo, correo, tipo, perfil_registrado,
                datos_corporales_registrado FROM USUARIO WHERE correo = '$user->correo' AND
                contrasena = '$pwd'");

                $id = $results[0]->codigo;

                \DB::insert(
                    "INSERT INTO CLIENTE (codigo_cliente, objetivo) VALUES ($id,NULL)"
                );


                $data = array(
                    'status' => 'register_success',
                    'code' => 200,
                    'message' => 'ACCOUNT_CORRECT',
                    'body' => $results,
                );

            }
        return response()->json($data, $data['code']);
    }

    public function login(Request $request)
    {
        $user = new Usuario($request->all());
      
        $validate = \Validator::make($request->all(), [

            'correo' => 'required|email',
            'contrasena' => 'required'
        ]);

       if ($validate->fails() || !is_object($user) ) {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'DOES',
                    'error' => $validate->errors()
                );
            } else {

                $pwd = hash('sha256', $user->contrasena);

                $results = \DB::select("SELECT codigo, correo, tipo, perfil_registrado,
                datos_corporales_registrado FROM USUARIO WHERE correo = 
                '$user->correo' AND contrasena ='$pwd'");
        
          
    
                     if (count($results) > 0 ) {
             
                        $data = array(
                        'status' => 'login_success',
                        'code' => 200,
                        'message' => 'ACCOUNT_CORRECT',
                        'body' =>  $results
                    );

                } else {
                    $data = array(
                        'status' => 'error',
                        'code' => 404,
                        'error' => 'error',
                        'message' => 'DOES_NOT_MATCH'
                    );
                 }

                }

        return response()->json($data, $data['code']);
    }
}
