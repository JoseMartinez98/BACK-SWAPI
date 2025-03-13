<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonajesControllerTest extends TestCase
{
    public function test_index_pagination_method()
    {

        $response = $this->get('/api/personajes');
        $response->assertStatus(200);

    }

    public function test_getPersonajes_method()
    {

        $response = $this->get('/api/allPersonajes');
        $response->assertStatus(200);

    }
}
