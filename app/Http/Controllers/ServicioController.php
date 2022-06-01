<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class ServicioController extends Controller
{
    public function getDetailedServices(){

        $today = Carbon::now();

        $data = Servicio::where('user_id', Auth::user()->id)->where('fecha', $today->toDateString())->with(['obra', 'obra.cliente', 'maquina'])->get();

        return new JsonResponse($data);
    }

    public function getSpecificServicio(Request $request){

        $today = Carbon::now();

        $data = Servicio::where('user_id', Auth::user()->id)->where('fecha', $today->toDateString())->where('id', $request->servicio_id)->with('obra', 'obra.cliente', 'maquina', 'trabajador')->get();

        if(count($data) == 0){
           abort(404); 
        }

        return new JsonResponse($data);
    }

    public function finalizarServicio(Request $request){

        $request->validate([
            'hora_fin' => 'required',
            'desplazamiento' => 'required',
            'm3' => 'required',
            'nombreFirmante' => 'required',
            'dni' => 'required',
            'firma' => 'required',
            'servicio_id' => 'required'
        ]);

        $servicio = Servicio::find($request->servicio_id);

        $servicio->hora_fin = $request->hora_fin;
        $servicio->desplazamiento = $request->desplazamiento;
        $servicio->m3 = $request->m3;
        $servicio->nombreFirmante = $request->nombreFirmante;
        $servicio->dni = $request->dni;
        $servicio->firmaCliente = $request->firma;
        $servicio->observaciones = $request->observaciones;
        $servicio->estado = false;


        if($servicio->save()){
            return new JsonResponse('Servicio finalizado con exito', 200);
        }

        abort(404);
    }


    //CRUD EndPoints
    public function getServicios(Request $request){
        

        $servicios = Servicio::where('obra_id', $request->obra_id)->with('trabajador', 'maquina', 'obra.cliente.email')->get();


        return new JsonResponse($servicios);
    }

    public function regServicio(Request $request){

        $request->validate([
            'fecha' => 'required',
            'hora_ini' => 'required',
            'numeracion' => 'required',
            'trabajador_id' => 'required',
            'maquina_id' => 'required',
            'obra_id' => 'required'
        ]);

        $servicio = new Servicio();

        $servicio->fecha = $request->fecha;
        $servicio->hora_ini = $request->hora_ini;
        $servicio->user_id = $request->trabajador_id;
        $servicio->maquina_id = $request->maquina_id;
        $servicio->obra_id = $request->obra_id;
        $servicio->numeracion = $request->numeracion;

        if($servicio->save()){
            return 'Servicio guardado correctamente';
        }

        return 'No se pudo guardar el servicio';

    }

    public function updateServicio(Request $request){

        $request->validate([
            'fecha' => 'required',
            'hora_ini' => 'required',
            'trabajador_id' => 'required',
            'maquina_id' => 'required',
            'servicio_id' => 'required'
        ]);

        $servicio = Servicio::find($request->servicio_id);

        $servicio->fecha = $request->fecha;
        $servicio->hora_ini = $request->hora_ini;
        $servicio->user_id = $request->trabajador_id;
        $servicio->maquina_id = $request->maquina_id;


        if($servicio->save()){
            return 'Servicio actualizado';
        }

        return 'No se pudo guardar el servicio';

    }

    public function deleteServicio(Request $request){

        $servicio = Servicio::find($request->servicio_id);

        if($servicio->delete()){
            return 'Servicio borrado correctamente';
        }

        return 'Ocurrio un error inesperado';
    }
}
