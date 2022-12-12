<?php

$router = $di->getRouter();

// Define your routes here
$router->add('/apis/{user_uri}',
    [
        'controller' => 'apis',
    ]
);

$router->add('/apis/{user_uri}/',
    [
        'controller' => 'apis',
    ]
);

$router->add('/apis/{user_uri}/{endpoint}/',
    [
        'controller' => 'apis',
    ]
);

$router->add('/apis/{user_uri}/{endpoint}',
    [
        'controller' => 'apis',
    ]
);

$router->handle($_SERVER['REQUEST_URI']);
