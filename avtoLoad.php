<?php

spl_autoload_register(function ($class){

    // Remove 'App\' from the class namespace
    $class = str_replace('App\\', '', $class);

    // Replace backslashes with forward slashes to form the correct path
    $path = __DIR__ . '/App/' . str_replace('\\', '/', $class) . '.php';

    // Check if the file exists and include it
    if (file_exists($path)) {
        require_once $path;
    } else {
        echo 'File not found: ' . $path;
    }
});

?>
