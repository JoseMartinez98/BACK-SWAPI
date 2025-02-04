<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Routes del modelo Naves
Route::get('naves','App\Http\Controllers\NavesController@getNaves');

Route::get('naves/{id}','App\Http\Controllers\NavesController@getNavesxid');

Route::post('addNaves','App\Http\Controllers\NavesController@insertNaves');

Route::put('updateNaves/{id}','App\Http\Controllers\NavesController@updateNaves');

Route::delete('deleteNaves/{id}','App\Http\Controllers\NavesController@deleteNaves');

//Routes del modelo Personajes
Route::get('personajes','App\Http\Controllers\PersonajesController@getPersonajes');

Route::get('personajes/{id}','App\Http\Controllers\PersonajesController@getPersonajesxid');

Route::post('addPersonajes','App\Http\Controllers\NavesController@insertPersonajes');

Route::put('updatePersonajes/{id}','App\Http\Controllers\PersonajesController@updatePersonajes');

Route::delete('deletePersonajes/{id}','App\Http\Controllers\PersonajesController@deletePersonajes');
