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

    public function handle()
    {
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
        $url = "https://swapi.dev/api/starships/";
        while ($url){
        $response = Http::timeout(60)->get($url);
        $data = $response->json();
        foreach ($data['results'] as $nave) {
            
            $naves = naves::Create([
                'name' => $nave['name'],
                'model' => $nave['model'],
                'cost_in_credits' => $nave['cost_in_credits'],
                'url' => $nave['url'],
                'passengers' => $nave['passengers'],
                'manufacturer' => $nave['manufacturer'],
                'image_url' => $this->obtenerImagenLocal($nave['url'], 'nave')
            ]);

            $url = $data['next'];

            foreach ($nave['pilots'] as $pilotUrl) {
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
                $naves->personajes()->attach($personaje->id_personajes);
                }
            }
        }
        $this->info("Importación de naves completada.");
        }

    public function importarPersonajes(){
        $url = "https://swapi.dev/api/people/";
        while ($url){
        $response = Http::timeout(60)->get($url);
        $data = $response->json();
        foreach ($data['results'] as $personaje) {

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
            $url = $data['next'];
            }
        } 
        $this->info("Importación de personajes completada.");
    }

    public function obtenerImagenLocal($url, $tipo){
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
