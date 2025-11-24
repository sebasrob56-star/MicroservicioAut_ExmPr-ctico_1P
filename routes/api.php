<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


    //Rutas publicas
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    //Validacion de Token(protegida con sanctum)
    Route::middleware('auth:sanctum')->get('/validate-token',function (Request $request) {
    // si el middleware auth:sanctum no funciona, se puede usar el siguiente

        $user = $request->user();
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'valid' => true,
        ])->header('Content-Type', 'application/json; charset=utf-8');
    });

    // Logout protegido por Sanctum
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

    // Rutas de compatibilidad con prefijo /api/auth/* (para colecciones antiguas en Postman)
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->get('/auth/validate-token', function (Request $request) {
        $user = $request->user();
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'valid' => true,
        ])->header('Content-Type', 'application/json; charset=utf-8');
    });
    Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);

