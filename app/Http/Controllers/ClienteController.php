<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Email;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function getClientes(Request $request){

        if($request->key){
            $data = Cliente::where('nombre', 'LIKE', '%'.$request->key.'%')->with('email')->get();
            return new JsonResponse($data);
        }

        $data = Cliente::with('email')->get();

        return new JsonResponse($data);
    }

    public function regCliente(Request $request){

        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'localidad' => 'required',
            'provincia' => 'required'
        ]);

        $newClient = new Cliente();
        $newClient->nombre = $request->nombre;
        $newClient->cif = $request->cif;
        $newClient->telefono = $request->telefono;
        $newClient->direccion = $request->direccion;
        $newClient->localidad = $request->localidad;
        $newClient->provincia = $request->provincia;
        $newClient->codigoPostal = $request->codigoPostal;

        if($newClient->save()){
            
            $emails = json_decode($request->email);
            if(count($emails) > 0){
                
                foreach ($emails as $email) {
                    $e = new Email();
                    $e->correo_cliente = $email->correo_cliente;
                    $e->cliente_id = $newClient->id;
                    $e->save();
                }
            }

            return 'Cliente guardado correctamente';
        }

        return 'No se pudo guardar el cliente';
    }

    public function updateCliente(Request $request){

        $request->validate([
            'id' => 'required',
            'nombre' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'localidad' => 'required',
            'provincia' => 'required'
        ]);

        $cliente = Cliente::find($request->id);

        $cliente->nombre = $request->nombre;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->localidad = $request->localidad;
        $cliente->provincia = $request->provincia;
        $cliente->cif = $request->cif;

        $cliente->email()->where('cliente_id', $cliente->id)->delete();
        $emails = json_decode($request->email);
        if(count($emails) > 0){
            
            foreach ($emails as $email) {
                $e = new Email();
                $e->correo_cliente = $email->correo_cliente;
                $e->cliente_id = $cliente->id;
                $e->save();
            }
        }

        if($cliente->save()){
            return 'Cliente actualizado';
        }

        return 'No se pudo guardar el cliente';
    }

    public function deleteCliente(Request $request){

        $cliente = Cliente::find($request->cliente_id);

        if($cliente->delete()){
            return 'Cliente borrado correctamente';
        }

        return 'Ocurrio un error inesperado';
    }
}
