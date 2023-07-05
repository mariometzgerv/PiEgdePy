<?php

use PiEdgePy\Router;

$router = new Router;

$router
    ->get('/', function () {
        require "views/main.php";
    });
