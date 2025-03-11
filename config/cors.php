<?php

return [



    'paths' => ['api/*','starwars*', '/naves','/personajes/upload-image', '/getNaves','/importar-naves', '/naves/{id_naves}/piloto/{id_personajes}', '/naves/{id_naves}/piloto/{id_personajes}','/personajes', '/allPersonajes', 'index'],

    'allowed_methods' => ['GET','POST','OPTIONS','DELETE','PUT'],

    'allowed_origins' => ['http://localhost:3000', 'http://localhost:5173', 'http://localhost:56823', 'http://localhost:50449','http://localhost:51989', 'http://localhost:5237', 'http://localhost:52375', 'http://localhost:55143'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
