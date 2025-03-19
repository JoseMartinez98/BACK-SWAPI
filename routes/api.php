<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavesController;
use App\Http\Controllers\PersonajesController;

// Rutas para las naves
Route::get('/naves', [NavesController::class, 'index']); 
Route::get('/allNaves', [NavesController::class, 'getNaves']); 
Route::delete('naves/{id}', [NavesController::class, 'destroy']);
Route::get('/naves/{id}', [NavesController::class, 'show']);
Route::post('/importar-naves', function () {
    Artisan::call('app:import-naves');
    return response()->json(['message' => 'Importación iniciada'], 200);
});
Route::post('/naves/{id_naves}/piloto/{id_personajes}', [NavesController::class, 'addPilot']); 
Route::delete('/naves/{id_naves}/piloto/{id_personajes}', [NavesController::class, 'removePilot']);

// Rutas para los personajes
Route::get('/personajes', [PersonajesController::class, 'index']); 
Route::get('/allPersonajes', [PersonajesController::class, 'getPersonajes']); 
Route::delete('personajes/{id}', [PersonajesController::class, 'destroy']);
Route::post('/personajes/upload-image', [PersonajesController::class, 'uploadImage']);
Route::post('/personajes', [PersonajesController::class, 'store']);




