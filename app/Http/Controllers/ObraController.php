<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ObraController extends Controller
{
    public function getObras(Request $request){

        if($request->key){
            $data = Obra::where('nombre', 'LIKE', '%'.$request->key.'%')->where('activo', true)->with('cliente')->orderBy('nombre', 'asc')->get();
            return new JsonResponse($data);
        }

        $data = Obra::where('activo', true)->with('cliente', 'servicio')->orderBy('nombre', 'asc')->get();

        return new JsonResponse($data);
    }

    public function regObra(Request $request){

        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'provincia' => 'required',
            'localidad' => 'required',
            'cliente_id' => 'required'
        ]);

        $obra = new Obra();
        $obra->nombre = $request->nombre;
        $obra->direccion = $request->direccion;
        $obra->provincia = $request->provincia;
        $obra->localidad = $request->localidad;
        $obra->cliente_id = $request->cliente_id;

        if($obra->save()){
            return 'Obra guardada correctamente';
        }

        return 'No se pudo guardar la obra';

    }

    public function updateObra(Request $request){

        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'estado' => 'required',
            'cliente_id' => 'required'
        ]);

        $obra = Obra::find($request->id);

        $obra->nombre = $request->nombre;
        $obra->direccion = $request->direccion;
        $obra->provincia = $request->provincia;
        $obra->localidad = $request->localidad;
        $obra->cliente_id = $request->cliente_id;
        
        $request->provincia ? $obra->provincia = $request->provincia : $obra->provincia = "";
        $request->localidad ? $obra->localidad = $request->localidad : $obra->localidad = "";

        if($request->estado == '1' || $request->estado == 'true'){
            $obra->estado = 1;
        }else{
            $obra->estado = 0;
        }

        if($obra->save()){
            return 'Obra actualizada';
        }

        return 'No se pudo guardar la obra';

    }

    public function deleteObra(Request $request){

        $obra = Obra::find($request->obra_id);

        if($obra->delete()){
            return 'Obra borrada correctamente';
        }

        abort(404);
    }
}