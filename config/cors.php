<?php

return [

    'paths' => ['api/*', 'graphql', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [],

    'allowed_origins_patterns' => ['*'],

    'allowed_headers' => ['*'],

    'supports_credentials' => true,

    'exposed_headers' => [],

    'max_age' => 0,

];
