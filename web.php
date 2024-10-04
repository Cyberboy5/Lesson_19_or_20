<?php

USE App\controllers\Controllers;
USE App\routes\Route;

Route::get('/',[controllers::class,'index']);
Route::get('/test',[controllers::class,'test']);

?>