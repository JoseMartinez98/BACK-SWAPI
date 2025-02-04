<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\naves;
use App\Models\personajes;
use App\Models\nave_personaje;
use Illuminate\Support\Facades\DB;

class ImportNaves extends Command
{
 
    protected $signature = 'app:import-naves';
    protected $description = 'Command description';

    public function handle()
    {
        $this->info("Reseteando base de datos...");
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        naves::truncate();
        personajes::truncate();
        nave_personaje::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $url = "https://swapi.dev/api/starships/";

        do {
            $response = Http::get($url);
            $data = $response->json();
            foreach ($data['results'] as $nave) {
                $naves = naves::Create([
                    'name' => $nave['name'],
                    'model' => $nave['model'],
                    'cost_in_credits' => $nave['cost_in_credits'],
                    'url' => $nave['url']
                ]);

                foreach ($nave['pilots'] as $personaje) {
                    $personajes = Http::get($personaje)->json();
                    $personaje = personajes::updateOrCreate(
                        ['name' => $personajes['name'],
                        'gender' => $personajes['gender'],
                        'url' => $personajes['url']
                    ]);
                    
                    $naves->personajes()->attach($personaje->id_personajes);
                }
            }
            $url = $data['next'];
        } while ($url);

        $this->info("Importación completada.");
    }
    
}
