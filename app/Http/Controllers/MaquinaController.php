<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaquinaController extends Controller
{
    public function getMaquinas(Request $request){

        if($request->key){
            $data = Maquina::where('matricula', 'LIKE', '%'.$request->key.'%')->where('activo', true)->get();
            return new JsonResponse($data);
        }

        $data = Maquina::where('activo', true)->get();

        return new JsonResponse($data);
    }

    public function regMaquina(Request $request){

        $request->validate([
            'tipo' => 'required',
            'matricula' => 'required',
        ]);

        $maquina = Maquina::where('matricula', $request->matricula)->first();

        if($maquina){
            
            $maquina->tipo = $request->tipo;
            $maquina->activo = true;

            if($maquina->save()){
                return;
            }
            
            abort(404);
        }

        $maquina = new Maquina();
        $maquina->tipo = $request->tipo;
        $maquina->matricula = $request->matricula;

        if($maquina->save()){
            return 'Maquina guardada correctamente';
        }

        return 'No se pudo guardar la maquina';
    }

    public function updateMaquina(Request $request){

        $request->validate([
            'tipo' => 'required',
            'matricula' => 'required',
        ]);

        $maquina = Maquina::find($request->id);

        $maquina->tipo = $request->tipo;
        $maquina->matricula = $request->matricula;

        if($maquina->save()){
            return 'Maquina actualizada';
        }

        return 'No se pudo guardar la maquina';
    }

    public function deleteMaquina(Request $request){

        $maquina = Maquina::find($request->maquina_id);

        $maquina->activo = false;

        if($maquina->save()){
            return 'Maquina borrada correctamente';
        }

        return 'No se pudo borrar la maquina';
    }
}
