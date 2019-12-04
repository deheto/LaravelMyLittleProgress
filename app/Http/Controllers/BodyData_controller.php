<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Datos_Corporales

class BodyData_controller extends Controller
{
    public function modifyBodyData(Request $request)
    {
        $bodyData = new Datos_Corporales($request->all());
            $validate = \Validator::make($request->all(),[
                'peso' => 'required|numeric',
                'altura' => 'required|numeric',
                'indice_grasa' => 'required|numeric',
                'indice_MasaMuscular' => 'required|numeric',
                'codigo_cliente' => 'required|numeric',
                'fecha' => 'required|date',
            ]);
    
            if ($validate->fails() || !is_object($bodyData)) {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Error al modificar datos',
                    'error' => $validate->errors()
                );

            } else {
                \DB::insert(
                    "INSERT INTO DATOS_CORPORALES (peso, altura, indice_grasa, indice_MasaMuscular, codigo_cliente, fecha) VALUES (?,?,?,?,?,?)",
                    [$bodyData->peso, $profile->altura,
                    $profile->indice_grasa,$profile->indice_MasaMuscular, $profile->codigo_cliente, $profile->fecha]
                );
                $data = array(
                    'status' => 'correct',
                    'code' => 200,
                    'message' => 'Los datos corporales se han modiicado correctamente'
                );

            }

        return response()->json($data, $data['code']);
    }
}
