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

        $user = User::where('email', $request->email)->first();

        if($user){
            
            $user->nombre = $request->nombre;
            $user->apellidos = $request->apellidos;
            $user->telefono = $request->telefono;
            $user->email = $request->email;
            $user->activo = true;

            if($request->rol == "true"){
                $user->rol_id = 1;
            }else{
                $user->rol_id = 2;
            }

            if($user->save()){
                return;
            }
            
            abort(404);
        }

        $user = new User();
        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->password = bcrypt('Pa$$word1');

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
        }else if($request->rol == "false"){
            $user->rol_id = 2;
        }


        if($user->save()){
            return 'Usuario actualizado correctamente';
        }

        return 'Ocurrieron errores';
    }

    public function deleteUser(Request $request){

        if(Auth::id() == $request->user_id){
            abort(403);
        }

        $user = User::find($request->user_id);

        $user->activo = false;

        if($user->save()){
            return 'Cliente borrado correctamente';
        }

        return 'Ocurrio un error inesperado';
    }

    public function resetPassword(Request $request){
        
        $user = User::find($request->user_id);

        $user->password = bcrypt('Pa$$word1');
        $user->passwordReset = 1;

        if($user->save()){
            return 'Usuario actualizado correctamente';
        }

        return 'Ocurrieron errores';
    }

    public function updatePassword(Request $request){

        $user = User::find($request->user_id);

        $user->password = bcrypt($request->password);
        $user->passwordReset = 0;

        if($user->save()){
            return 'Contraseña actualizada correctamente';
        }

        return 'Ocurrieron errores';
    }

    public function regSign(Request $request){

        $user = User::find($request->user_id);

        $user->firmaUser = $request->firmaUser;
        $user->primerInicio = 0;

        if($user->save()){
            return 'Firma seteada correctamente';
        }

        abort(404);
    }
}