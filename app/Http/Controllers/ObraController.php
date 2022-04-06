<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ObraController extends Controller
{
    public function getAll(){
        $data = Obra::with('cliente')->get();

        return new JsonResponse($data);
    }

    public function getSpecific($id){

        $data = Obra::with(['cliente', 'email', 'servicios.maquina', 'servicios.trabajador', 'servicios.albaran'])->findOrFail(1);

        return new JsonResponse($data);
    }
}
