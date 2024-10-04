<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

USE App\app;

include 'avtoLoad.php';
include 'web.php';

$app = new App();

$app->run();

?>