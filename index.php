<?php

    require_once __DIR__ . "/app/autoloader.app.php";

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTION');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Access-Control-Allow-Credentials: true');

    $app = new \App\App;
    $app->boot();
    $app->validate();
    $app->authenticate();
    $app->serve();
