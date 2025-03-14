<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\personajes;
use App\Models\naves;
use Illuminate\Support\Facades\Http;


class PersonajesController extends Controller{

   public function getPersonajes() {
    //Function used to get all characters from API saved in database
        $pilots = personajes::All();
        return response()->json($pilots);
    }
    
    
    public function index(){
    //Function used to get all characters from API saved in database with pagination

        $pilots = personajes::with('naves')->paginate(10); 
        return response()->json($pilots);
    }

    public function destroy($id){
    //Function used to destroy a character from de database.

        $personaje = personajes::find($id);
            if (!$personaje) {
                return response()->json(['message' => 'Personaje no encontrado'], 404);
            }
        $personaje->delete();
        return response()->json(['message' => 'Personaje eliminado exitosamente'], 200);
    }

    public function uploadImage(Request $request){
    //Function used to post the photo on the front and save it in the back folder
        $request->validate([
        'image' => 'required|image|mimes:png|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();  
        $request->image->move(public_path('personajes'), $imageName);

        return response()->json(['image_url' => asset('personajes/' . $imageName)]);
    }

    public function store(Request $request){
        //Function used tu check the data of custom character
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
    //Function used to find a specific character searching his ID

        $personaje = personajes::with('naves')->find($id);
            if (!$personaje) {
                return response()->json(['message' => 'Personaje no encontrado'], 404);
            }
        return response()->json($personaje);
    }
}
