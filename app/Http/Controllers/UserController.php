<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller{

    public function getAutenticatedUser(){

        $user = Auth::user();
        $user->rol;

        return new JsonResponse($user);
    }

    public function getUsers(Request $request){

        if($request->key){
            $users = User::where('nombre', 'LIKE', '%'.$request->key.'%')->where('activo', true)->with('rol')->get();
            return new JsonResponse($users);
        }
        
        $users = User::where('activo', true)->with('rol')->get();

        return new JsonResponse($users);
    }

    public function regUser(Request $request){

        $request->validate([
            'nombre' => 'required',
            'email' => 'required',
            'telefono' => 'required'
        ]);

        $user = new User();
        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->password = bcrypt('pa$$word1');

        if($request->rol == "true"){
            $user->rol_id = 1;
        }else{
            $user->rol_id = 2;
        }

        if($user->save()){
            return 'Usuario guardado correctamente';
        }

        return 'Ocurrieron errores';
    }

    public function updateUser(Request $request){

        $request->validate([
            'nombre' => 'required',
            'email' => 'required',
            'telefono' => 'required'
        ]);

        $user = User::find($request->id);

        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        
        if($request->rol == "true"){
            $user->rol_id = 1;
        }else{
            $user->rol_id = 2;
        }

        if($user->save()){
            return 'Usuario actualizado correctamente';
        }

        return 'Ocurrieron errores';
    }

    public function deleteUser(Request $request){

        $user = User::find($request->user_id);

        if($user->delete()){
            return 'Cliente borrado correctamente';
        }

        return 'Ocurrio un error inesperado';
    }

    public function resetPassword(Request $request){
        
        $user = User::find($request->user_id);

        $user->password = bcrypt('pa$$word1');

        if($user->save()){
            return 'Usuario actualizado correctamente';
        }

        return 'Ocurrieron errores';
    }
}