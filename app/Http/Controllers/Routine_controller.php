<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Routine_controller extends Controller
{
  
    public function getRoutine(Request $request)
    {   


        $id =  $request->codigo_cliente;

        $validate = \Validator::make($request->all(),[
            'codigo_cliente' => 'required|numeric|unique:RUTINA_CLIENTES',
        ]);

        if ($validate->fails()) {
    
         
        $userProfile = \DB::select("SELECT * FROM EJERCICIOS ej INNER JOIN  RUTINA_CLIENTES rc 
         ON ej.id_rutina = rc.id INNER JOIN ACTIVIDAD ac ON ej.id_actividad = ac.identificacion
        ");

         
        $data = array(
            'status' => 'correct',
            'code' => 200,
            'message' => 'SUCCESS',
            'body' =>  $userProfile
        );

        } else {

            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'USER_DOES_NOT_EXISTS',
                'error' => 'USER_NOT_FOUND'
            );
        }


        return response()->json($data, $data['code']);

    }

}
