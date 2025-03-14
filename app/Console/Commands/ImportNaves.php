<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\naves;
use App\Models\personajes;
use App\Models\nave_personaje;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportNaves extends Command{
    protected $signature = 'app:import-naves';
    protected $description = 'Command description';

    public function handle(){
        //this fuction clean and prepare the Database to restart the dates from the API and images of public folder in laravel project
        $this->info("Reseteando base de datos...");
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        nave_personaje::query()->delete();
        naves::truncate();
        personajes::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->eliminarImagenes();
        $this->importarNaves();
        $this->importarPersonajes();
    }

    public function importarNaves(){
        $url = "https://swapi.dev/api/starships/"; //url of all starships from the API
        while ($url){
        $response = Http::timeout(60)->get($url); //time to connect to the API
        $data = $response->json();  //dates from API in json format 
        foreach ($data['results'] as $nave) { //loop that fills each column of the table with data from the API
            
            $naves = naves::Create([
                'name' => $nave['name'],
                'model' => $nave['model'],
                'cost_in_credits' => $nave['cost_in_credits'],
                'url' => $nave['url'],
                'passengers' => $nave['passengers'],
                'manufacturer' => $nave['manufacturer'],
                'image_url' => $this->obtenerImagenLocal($nave['url'], 'nave')
            ]);

            $url = $data['next']; //It is used to pass the pagination of the API

            foreach ($nave['pilots'] as $pilotUrl) { //loop to populate the characters table with existing ship pilots
                $personajeData = Http::timeout(60)->get($pilotUrl)->json();
                $personaje = personajes::updateOrCreate(
                    ['url' => $personajeData['url']], 
                    [
                        'name' => $personajeData['name'],
                        'gender' => $personajeData['gender'],
                        'birth_year' => $personajeData['birth_year'],
                        'height' => $personajeData['height'],
                        'mass' => $personajeData['mass'],
                        'image_url' => $this->obtenerImagenLocal($personajeData['url'], 'personaje')
                    ]
                );
                $naves->personajes()->attach($personaje->id_personajes); //join ships and characters in the pivot table
                }
            }
        }
        $this->info("Importación de naves completada.");
        }

    public function importarPersonajes(){
        $url = "https://swapi.dev/api/people/"; //url of all characters from the API
        while ($url){
        $response = Http::timeout(60)->get($url); //time to connect to the API
        $data = $response->json(); //dates from API in json format
        foreach ($data['results'] as $personaje) { //loop that fills each column of the table with data from the API

            Personajes::updateOrCreate(
                ['url' => $personaje['url']], 
                [
                    'name' => $personaje['name'],
                    'gender' => $personaje['gender'],
                    'birth_year' => $personaje['birth_year'],
                    'height' => $personaje['height'],
                    'mass' => $personaje['mass'],
                    'image_url' => $this->obtenerImagenLocal($personaje['url'], 'personaje')
                ]
            );
            $url = $data['next']; //It is used to pass the pagination of the API
            }
        } 
        $this->info("Importación de personajes completada.");
    }

    public function obtenerImagenLocal($url, $tipo){ 
    //Function used to check the ID of the character or ship with the ID of the photo in the local project folder, 
    // thus saving the photo of each character or ship in the database, since the API did not provide photos.
        $carpeta = $tipo === 'nave' ? 'naves' : 'personajes';
        preg_match('/\/(\d+)\/$/', $url, $matches);
        $id = $matches[1] ?? null;
    
            if (!$id) {
                return asset("$carpeta/default.png"); 
            }
            $imagePath = public_path("$carpeta/$id.png"); 
            
            if (file_exists($imagePath)) {
                return asset("$carpeta/$id.png"); 
            }
        return asset("$carpeta/default.png"); 
    }

    public function eliminarImagenes(){
    //Function that is used to delete all photos of custom characters starting with ID 83, 
    // since when we create a character it is assigned from that ID
        $carpetaPersonajes = public_path('personajes');
        $archivos = File::files($carpetaPersonajes); 
        foreach ($archivos as $archivo) {
            $nombreArchivo = $archivo->getFilename();
            $numeroImagen = (int) pathinfo($nombreArchivo, PATHINFO_FILENAME); 

            if ($numeroImagen > 83) {
                File::delete($archivo);
                $this->info("Imagen $nombreArchivo eliminada.");
            }
        }
    }
}
