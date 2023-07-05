<?php

spl_autoload_register(function ($class) {
    $namespace = str_replace("PiEdgePy", "src", $class);
    $file = __DIR__ . "/" . str_replace("\\", "/", $namespace) . ".php";
    if (file_exists($file)) require_once $file;
});
