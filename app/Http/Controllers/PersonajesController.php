<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\personajes;
use Illuminate\Support\Facades\Http;


class PersonajesController extends Controller
{
    public function getPersonajes(){
        $response = Http::get('https://swapi.dev/api/people/');
        return $response->json();
    }

    public function getPersonajesxid($id){
        $personajes = personajes::find($id);
        if (is_null($personajes)) {
            return response()->json(['mensaje'=>'Registro no encontrado'],404);
        }
        return response()->json($personajes::find($id),200);
    }

    public function insertPersonajes(Request $request){
        $personajes = personajes::create($request->all());
        return response($personajes,200);
    }

    public function updatePersonajes(Request $request,$id){
        $personajes = personajes::find($id);
        if (is_null($personajes)) {
            return response()->json(['mensaje'=>'Registro no encontrado'],404);
        }
        $personajes->update($request->all());
        return rsponse($personajes,200);
    }

    public function deletePersonajes($id){
        $personajes = personajes::find($id);
        if (is_null($personajes)) {
            return response()->json(['mensaje'=>'Registro no encontrado'],404);
        }
        $personajes->delete();
        return response()->json(['mensaje'=>'Registro eliminado',200]);
    }
}
