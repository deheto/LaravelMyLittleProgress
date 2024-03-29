<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Datos_Corporales;
class BodyData_controller extends Controller
{
    public function addBodyData(Request $request)
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
                    'message' => 'INCORRECT_DATA',
                    'error' => $validate->errors()
                );

            } else {

                \DB::insert(
                    "INSERT INTO DATOS_CORPORALES (peso, altura, indice_grasa, indice_MasaMuscular, codigo_cliente, fecha) VALUES (?,?,?,?,?,?)",
                    [$bodyData->peso, $bodyData->altura,
                    $bodyData->indice_grasa,$bodyData->indice_MasaMuscular, $bodyData->codigo_cliente, $bodyData->fecha]
                );

                \DB::update("UPDATE USUARIO SET datos_corporales_registrado = '1' WHERE USUARIO.codigo = '$bodyData->codigo_cliente'"
              );

                $data = array(
                    'status' => 'SUCCESS',
                    'code' => 200,
                    'message' => 'Los datos corporales se han modificado correctamente',
               
                );

            }

        return response()->json($data, $data['code']);
    }
}
