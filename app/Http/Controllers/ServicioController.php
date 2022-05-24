<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    public function getDetailedServices(){

        $today = Carbon::now();

        $data = Servicio::where('user_id', Auth::user()->id)->where('fecha', $today->toDateString())->with(['obra', 'obra.cliente', 'maquina'])->get();

        return new JsonResponse($data);
    }
}
