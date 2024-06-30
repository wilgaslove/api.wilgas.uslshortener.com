<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(){

    }
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth()->user();

            $success['token'] = $user->createToken('token')->plainTextToken ;
            $success['user']=$user;
            return response()->json([
                'success' => true,
                'data' => $success,
                'message' => 'Authentification réusssite'
            ]);
        }

        return response()->json([
            'success' => false,
            "erreur" => "Identifiants non corrects",
        ], 401);

    }

    public function logout(Request $request){
        //On supprime tous les tokens associé au user
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie',
        ]);

    }
}
