<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\naves;
use App\Models\personajes;
use Illuminate\Support\Facades\Http;




class NavesController extends Controller{

    public function index(){
    //Function used to retrieve the list of all ships with their data and the pilots already linked to the API stored in the database.
        $starships = naves::with('personajes')->paginate(8);
        return response()->json($starships);
    }

    public function getNaves() {
    //Function used to retrieve the list of all ships with their data
        $starships = naves::paginate(8);
        return response()->json($starships);
    }

    public function destroy($id) {
    //Function used to destroy a ship from de database.
        try {
            $starship = naves::findOrFail($id);
            $starship->delete();
            return response()->json(['message' => 'Nave eliminada exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la nave: ' . $e->getMessage()], 500);
        }
    }

    public function addPilot($id_naves, $id_personajes){
    //Function used to attach a character with a ship.
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
    //Function used to unattach a chracter from a ship.
        $starship = naves::findOrFail($id_naves);
        $pilot = personajes::findOrFail($id_personajes);
        $starship->personajes()->detach($pilot->id_personajes);

        return response()->json(['message' => 'Piloto eliminado exitosamente.']);
    }

    public function show($id){
    //Function used to find a specific ship searching his ID
        $nave = naves::with('personajes')->find($id);
        if (!$nave) {
            return response()->json(['message' => 'nave no encontrado'], 404);
        }
        return response()->json($nave);
    }

}


