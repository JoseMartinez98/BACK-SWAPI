<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\personajes;
use App\Models\naves;
use Illuminate\Support\Facades\Http;


class PersonajesController extends Controller
{
   public function getPersonajes() {
    $pilots = personajes::All();
    return response()->json($pilots);
    }
    
    
    public function index()
    {
        $pilots = personajes::with('naves')->paginate(10); 
        return response()->json($pilots);
    }
    public function destroy($id)
    {
        $personaje = personajes::find($id);
        if (!$personaje) {
            return response()->json(['message' => 'Personaje no encontrado'], 404);
        }
        $personaje->delete();
        return response()->json(['message' => 'Personaje eliminado exitosamente'], 200);
    }


     public function getImageUrlAttribute(){
        return asset("personajes/{$this->id_personajes}.png");
    }


    public function uploadImage(Request $request){
    $request->validate([
        'image' => 'required|image|mimes:png,jpg,gif,svg|max:2048',
    ]);

    $imageName = time() . '.' . $request->image->extension();  
    $request->image->move(public_path('personajes'), $imageName);

    return response()->json(['image_url' => asset('personajes/' . $imageName)]);
}

public function store(Request $request){
    $request->validate([
        'name' => 'required|string|max:255',
        'gender' => 'required|string|max:255',
        'birth_year' => 'required|string|max:255',
        'height' => 'required|string|max:255',
        'mass' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
    ]);

    $personaje = personajes::create([
        'name' => $request->name,
        'gender' => $request->gender,
        'birth_year' => $request->birth_year,
        'height' => $request->height,
        'mass' => $request->mass,
        'image_url' => null,  
    ]);

    if ($request->hasFile('image')) {
        $image = $request->file('image');

        if ($image->isValid()) {

            $imageExtension = $image->extension();
            $imageName = $personaje->id_personajes . '.' . $imageExtension;
            $image->move(public_path('personajes'), $imageName);
            $imageUrl = asset('personajes/' . $imageName);
            $personaje->update([
                'image_url' => $imageUrl,  
            ]);
        } else {
            return response()->json(['message' => 'Error al subir la imagen'], 400);
        }
    }
    return response()->json($personaje, 201);
}

public function show($id){
    $personaje = personajes::with('naves')->find($id);
    if (!$personaje) {
        return response()->json(['message' => 'Personaje no encontrado'], 404);
    }
    return response()->json($personaje);
}


}
