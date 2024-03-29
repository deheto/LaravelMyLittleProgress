<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Routine_controller extends Controller
{
    // 
    


    public function addExercise(Request $request)
    {   

        $validateData = \Validator::make($request->all(),[
            'series_totales' => 'required|numeric',
            'rep_totales' => 'required|numeric',
            'nombre' => 'required|alpha',
            'parte_cuerpo' => 'required|alpha',
            'id' => 'required|numeric'
        ]);

        if ($validateData->fails()) {

            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'DATA_INCORRECT',
                'error' => 'DATA_INCORRECT'
            );


        }else {

         $validateExists = \Validator::make($request->all(),[
             'id' => 'unique:RUTINA_CLIENTES',
         ]);

        if ($validateExists->fails()) {


        \DB::insert("INSERT INTO ACTIVIDAD (identificacion, nombre, parte_cuerpo) 
        VALUES (?, ?, ?)",[NULL,$request->nombre, $request->parte_cuerpo ]);
 
        $activitie = \DB::select("SELECT identificacion FROM ACTIVIDAD WHERE nombre = '$request->nombre'
        AND parte_cuerpo = '$request->parte_cuerpo'");
    
        $id_activitie = $activitie[0];
       

        
        \DB::insert("INSERT INTO EJERCICIOS (id_ejercicio, rep_totales,
         series_totales, id_actividad, id_rutina) VALUES (NULL, ?, ?, ?,?)",
         [$request->rep_totales,$request->series_totales, $id_activitie->identificacion,
         $request->id]);
 

        $data = array(
            'status' => 'correct',
            'code' => 200,
            'message' => 'SUCCESS'      
        );

        } else {

            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'DOEST_NOT_HAVE_ROUTINES',
                'error' => 'DOEST_NOT_HAVE_ROUTINES'
            );
        }
    }

        return response()->json($data, $data['code']);

    }


    public function getExercise(Request $request)
    {   

        $validateData = \Validator::make($request->all(),[
            'codigo_cliente' => 'required|numeric',
        ]);

        if ($validateData->fails()) {

            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'DATA_INCORRECT',
                'error' => 'DATA_INCORRECT'
            );


        }else {

        $validateExists = \Validator::make($request->all(),[
            'codigo_cliente' => 'unique:RUTINA_CLIENTES',
        ]);

        if ($validateExists->fails()) {
    
        $id =  $request->codigo_cliente;

        $exercise = \DB::select("SELECT * FROM EJERCICIOS ej INNER JOIN RUTINA_CLIENTES rc ON ej.id_rutina = rc.id INNER JOIN
         ACTIVIDAD ac ON ej.id_actividad = ac.identificacion WHERE rc.codigo_cliente = $id");
 
        $data = array(
            'status' => 'correct',
            'code' => 200,
            'message' => 'SUCCESS',
            'body' =>  $exercise
        );

        } else {

            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'DOEST_NOT_HAVE_ROUTINES',
                'error' => 'DOEST_NOT_HAVE_ROUTINES'
            );
        }
    }

        return response()->json($data, $data['code']);

    }


    public function getRoutine(Request $request)
    {   

        $validateData = \Validator::make($request->all(),[
            'codigo_cliente' => 'required|numeric',
        ]);

        if ($validateData->fails()) {

            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'DATA_INCORRECT',
                'error' => 'DATA_INCORRECT'
            );


        }else {

        $validateExists = \Validator::make($request->all(),[
            'codigo_cliente' => 'unique:RUTINA_CLIENTES',
        ]);

        if ($validateExists->fails()) {
    
        $id =  $request->codigo_cliente;

        $routine = \DB::select(" SELECT * FROM CLIENTE cl INNER JOIN RUTINA_CLIENTES rt
         on cl.codigo_cliente = rt.codigo_cliente WHERE cl.codigo_cliente = '$id'");
 
            //  SELECT * FROM CLIENTE cl INNER JOIN RUTINA_CLIENTES rt on cl.codigo_cliente = rt.codigo_cliente WHERE cl.codigo_cliente = '$id';

        $data = array(
            'status' => 'correct',
            'code' => 200,
            'message' => 'SUCCESS',
            'body' =>  $routine
        );

        } else {

            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'DOEST_NOT_HAVE_ROUTINES',
                'error' => 'DOEST_NOT_HAVE_ROUTINES'
            );
        }
    }

        return response()->json($data, $data['code']);

    }

    public function deleteExercise(Request $request)
    {   

        $validateData = \Validator::make($request->all(),[
            'id_ejercicio' => 'required|numeric',
        ]);

        if ($validateData->fails()) {

            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'DATA_INCORRECT',
                'error' => 'DATA_INCORRECT'
            );


        }else {

        $validateExists = \Validator::make($request->all(),[
            'id_ejercicio' => 'unique:EJERCICIOS',
        ]);

        if ($validateExists->fails()) {
    
        $id =  $request->id_ejercicio;

         \DB::delete("DELETE FROM EJERCICIOS WHERE id_ejercicio='$id'");
        $data = array(
            'status' => 'correct',
            'code' => 200,
            'message' => 'EXERCISE_ELIMINATED'
        );

        } else {

            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'EXERCISE_DOES_NOT_EXISTS',
                'error' => 'EXERCISE_DOES_NOT_EXISTS'
            );
        }
    }

        return response()->json($data, $data['code']);

    }

    public function addRoutine(Request $request)
    {   

        $validateData = \Validator::make($request->all(),[
            'codigo_cliente' => 'required|numeric',
            'descripcion' => 'required',
            'fecha' => 'required'            
        ]);

        if ($validateData->fails()) {

            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'DATA_INCORRECT',
                'error' => 'DATA_INCORRECT'
            );


        }else {

        $validateExists = \Validator::make($request->all(),[
            'codigo_cliente' => 'unique:CLIENTE',
        ]);

        if ($validateExists->fails()) {
    
         \DB::insert("INSERT INTO RUTINA_CLIENTES (fecha, descripcion,codigo_cliente ) VALUES (?,?,?)",
         [$request->fecha, $request->descripcion , $request->codigo_cliente]);

        //  \DB::insert("INSERT INTO EJERCICIOS (id_ejercicio, rep_totales, series_totales,
        //   id_actividad, id_rutina) VALUES (NULL, '0', '0', '11', '$request->codigo_cliente')");
  

        $data = array(
            'status' => 'correct',
            'code' => 200,
            'message' => 'ROUTINE_ADDED'
        );

        } else {

            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'EXERCISE_DOES_NOT_EXISTS',
                'error' => 'EXERCISE_DOES_NOT_EXISTS'
            );
        }
    }

        return response()->json($data, $data['code']);

    

    }
}
