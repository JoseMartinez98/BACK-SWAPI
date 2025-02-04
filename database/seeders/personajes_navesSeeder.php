<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\personajes_naves;
use Illuminate\Support\Facades\Http;


class personajes_navesSeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::get('https://swapi.dev/api/people/');
        $data = $response->json();
        $responseNave = Http::get('https://swapi.dev/api/starships/');
        $dataNave = $responseNave->json();
            if (isset($data['results'])) {
                foreach ($data['results'] as $item) {
                    if (isset($item['starships'])) {
                        foreach ($item['starships'] as $starshipUrl) {
                            if (isset($dataNave['results'])) {
                                foreach ($dataNave['results'] as $nameNave) {
                                    Personajes_naves::create([
                                        'nave' => $nameNave['name'],
                                        'piloto' => $item['name']
                                    ]);
                                }   
                            }
                        }
                    }
                }
                
            }   else {
                Log::error('Error al obtener los datos de la API de Star Wars.');
        }
    }
}
