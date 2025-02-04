<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\naves;
use Illuminate\Support\Facades\Http;




class NavesController extends Controller
{
    public function index()
    {
        return naves::with('pilots')->get();
    }
    
    public function getNaves(){
        $response = Http::get('https://swapi.dev/api/starships/');
        return $response->json();
    }

    public function getNavesxid($id){
        $naves = naves::find($id);
        if (is_null($naves)) {
            return response()->json(['mensaje'=>'Registro no encontrado'],404);
        }
        return response()->json($naves::find($id),200);
    }

    public function insertNaves(Request $request){
        $naves = naves::create($request->all());
        return response($naves,200);
    }

    public function updateNaves(Request $request,$id){
        $naves = naves::find($id);
        if (is_null($naves)) {
            return response()->json(['mensaje'=>'Registro no encontrado'],404);
        }
        $naves->update($request->all());
        return rsponse($naves,200);
    }

    public function deleteNves($id){
        $naves = naves::find($id);
        if (is_null($naves)) {
            return response()->json(['mensaje'=>'Registro no encontrado'],404);
        }
        $naves->delete();
        return response()->json(['mensaje'=>'Registro eliminado',200]);
    }

}
