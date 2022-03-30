<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Email;
use App\Models\Obra;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ObraController extends Controller
{
    public function index($id){

        $data = Obra::with(['cliente', 'email'])->findOrFail(1);

        return new JsonResponse($data);
    }
}
