<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\personajes;
use App\Http\Controllers\PersonajesController;
use Illuminate\Support\Facades\Http;

class personajesSeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::get('https://swapi.dev/api/people/');
        $data = $response->json();
        
            if (isset($data['results'])) {
                foreach ($data['results'] as $item) {
                    personajes::create([
                        'name' => $item['name'],
                        'gender' => $item['gender'],
                        'url' => $item['url']
                    ]);
                }
            }   else {
                Log::error('Error al obtener los datos de la API de Star Wars.');
        }
    }
}
