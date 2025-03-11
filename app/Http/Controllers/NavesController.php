<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\naves;
use App\Models\personajes;
use Illuminate\Support\Facades\Http;




class NavesController extends Controller
{


public function index(){
    $starships = naves::with('personajes')->paginate(8);
    return response()->json($starships);
}

public function getNaves() {
    $starships = naves::paginate(8);
    return response()->json($starships);
}
public function destroy($id) {
    try {
        $starship = naves::findOrFail($id);
        $starship->delete();
        return response()->json(['message' => 'Nave eliminada exitosamente.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar la nave: ' . $e->getMessage()], 500);
    }
}

public function addPilot($id_naves, $id_personajes){
    try {
        $starship = naves::findOrFail($id_naves);
        $pilot = personajes::findOrFail($id_personajes);

        // Vincula al piloto con la nave
        $starship->personajes()->attach($pilot->id_personajes);

        return response()->json(['message' => 'Piloto vinculado exitosamente.']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function removePilot($id_naves, $id_personajes){
    $starship = naves::findOrFail($id_naves);
    $pilot = personajes::findOrFail($id_personajes);
    $starship->personajes()->detach($pilot->id_personajes);

    return response()->json(['message' => 'Piloto eliminado exitosamente.']);
}

public function show($id){
    $nave = naves::with('personajes')->find($id);
    if (!$nave) {
        return response()->json(['message' => 'nave no encontrado'], 404);
    }
    return response()->json($nave);
}

}


