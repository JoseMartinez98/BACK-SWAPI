<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\naves;
use App\Models\personajes;

class NavesControllerTest extends TestCase
{
    public function test_index_method()
    {

        $response = $this->get('/api/naves');
        $response->assertStatus(200);

    }

    public function test_addPilots_method()
    {
        $id_naves = 1;
        $id_personajes = 1;
        $url = "/api/naves/{$id_naves}/piloto/{$id_personajes}";
        $response = $this->post($url);
        $response->assertStatus(200);

    }

    public function test_removePilots_method()
    {
        $id_naves = 1;
        $id_personajes = 1;
        $url = "/api/naves/{$id_naves}/piloto/{$id_personajes}";
        $response = $this->delete($url);
        $response->assertStatus(200);

    }

}
