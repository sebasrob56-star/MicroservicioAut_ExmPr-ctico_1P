<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422)
                ->header('Content-Type', 'application/json; charset=utf-8');
        }

        $data = $validator->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        //Generación de token despues del registro
       $token =$user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                //'role' => $user->role,
            ],
        ], 201)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422)
                ->header('Content-Type', 'application/json; charset=utf-8');
        }

        $data = $validator->validated();

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'errors' => ['email' => ['Las credenciales proporcionadas son incorrectas.']]
            ], 422)->header('Content-Type', 'application/json; charset=utf-8');
        }
        // Elimina tokens viejos y crea uno nuevo
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario conectado exitosamente',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                //'role' => $user->role,
            ],
        ], 201)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }
        return response()->json(['message' => 'Logout exitoso'])->header('Content-Type', 'application/json; charset=utf-8');
    }



  //  private static function abilitiesForRole(string $role): array
   // {
    //    return match ($role) {
     //       'admintrador' => ['*'],
      //      'editor' => ['read', 'write'],
       //     'usuario' => ['read'],
       //     default => ['read'], // 'user'
        //};

    //}
}
