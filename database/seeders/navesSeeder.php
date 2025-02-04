<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\naves;
use App\Http\Controllers\NavesController;
use Illuminate\Support\Facades\Http;

class navesSeeder extends Seeder {
    public function run(): void
    {
        $response = Http::get('https://swapi.dev/api/starships/');
        $data = $response->json();
        
            if (isset($data['results'])) {
                foreach ($data['results'] as $item) {
                    naves::create([
                        'name' => $item['name'],
                        'model' => $item['model'],
                        'cost_in_credits' => $item['cost_in_credits'],
                        'url' => $item['url']
                    ]);
                }
            }   else {
                Log::error('Error al obtener los datos de la API de Star Wars.');
        }
    }
}