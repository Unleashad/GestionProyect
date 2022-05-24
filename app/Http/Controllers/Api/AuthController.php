<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $newUser = new User();
        $newUser->nombre = $request->nombre;
        $newUser->apellidos = $request->apellidos;
        $newUser->telefono = $request->telefono;
        $newUser->email = $request->email;
        $newUser->password = bcrypt($request->password);
        $newUser->rol_id = $request->rol_id;

        if($newUser->save()){
            return 'nais';
        }

        return 'fail';
    }

    public function login(Request $request){
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            return new JsonResponse(['message' => 'Los datos no son validos'], 422);
        }

        $user = Auth::user();
        
        if($user->activo)
        {
            $authToken = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'access_token' => $authToken
            ]);
        }
        

        return new JsonResponse(['message' => 'Los datos no son validos'], 422);
    }
}
